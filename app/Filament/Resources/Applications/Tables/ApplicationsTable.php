<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\User;
use App\Enums\status;
use App\Models\Applicant;
use App\Models\JobVacancy;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\Action;
use App\Models\ErpIntegration;
use App\Models\JobVacancyStage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InterviewSession;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;
use App\Http\Resources\ApplicantResource;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ApplicantApiResource;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\TestResultApiResource;
use App\Http\Resources\CandidateSyncApiResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->whereRelation('jobVacancy', 'status', true))
            ->groups([
                Group::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->collapsible(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('user.latestEducation.education_level')
                    ->label('Pendidikan Terakhir')
                    ->searchable(),
                TextColumn::make('user.latestEducation.major')
                    ->label('Jurusan')
                    ->searchable(),
                TextColumn::make('user.latestEducation.university')
                    ->label('Universitas')
                    ->searchable(),
                TextColumn::make('user.latestEducation.gpa')
                    ->label('IPK')
                    ->searchable(),
                TextColumn::make('latestStageProgress.jobVacancyStage.stageType.name')
                    ->badge()
                    ->label('Tahap'),
                TextColumn::make('latestStageProgress.status')
                    ->badge()
                    ->label('Status'),
                SelectColumn::make('final_status')
                    ->label('Status Akhir')
                    ->options([
                        'pending' => 'Pending',
                        'hired' => 'Diterima',
                        'reject' => 'Ditolak',
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(),
            ])
            ->filters([
                SelectFilter::make('job_vacancy_id')
                    ->label('Lowongan')
                    ->options(JobVacancy::query()->pluck('title', 'id'))
            ])
            ->recordActions([
                Action::make('createStageProgress')
                    ->label('Tambah Tahap Lamaran')
                    ->icon(LucideIcon::ArrowDown01)
                    ->schema(function ($record) {
                        return [
                            Select::make('job_vacancy_stage_id')
                                ->label('Tahap Lamaran')
                                ->options(
                                    JobVacancyStage::with('stageType')
                                        ->where('job_vacancy_id', $record->job_vacancy_id)
                                        ->get()
                                        ->mapWithKeys(fn($stage) => [$stage->id => $stage->stageType->name])
                                )
                                ->searchable(),
                            Select::make('status')
                                ->label('Status')
                                ->options(status::class),
                            DatePicker::make('started_at')
                                ->label('Mulai'),
                            DatePicker::make('decided_at')
                                ->label('Selesai'),
                            Select::make('decided_by')
                                ->label('Diterima Oleh')
                                ->options(
                                    User::query()
                                        ->whereRelation('roles', 'name', '!=', 'applicant')
                                        ->pluck('name', 'id')
                                ),
                            Textarea::make('note')
                                ->columnSpanFull()
                                ->label('Catatan'),
                            TextInput::make('score')
                                ->label('Skor'),
                        ];
                    })
                    ->databaseTransaction()
                    ->action(function ($record, array $data) {
                        $record->update([
                            'current_stage_id' => $data['job_vacancy_stage_id'],
                        ]);

                        $record->stageProgresses()->create($data);
                    }),
                Action::make('printResume')
                    ->label('Cetak Resume')
                    ->icon(LucideIcon::Printer)
                    ->action(function (Model $record) {
                        // ds($record->interviewSessionApplications->interviewSession);

                        $interviewSession =  InterviewSession::query()
                            ->with([
                                'interviewForm.criterias.scales',
                                'interviewApplications' => function ($query) use ($record) {
                                    $query->where('application_id', $record->id);
                                },
                                'interviewEvaluators.user',
                            ])
                            ->first();

                        // ds($interviewSession->interviewEvaluators->where('interview_session_id', $interviewSession->id));

                        return response()->streamDownload(function () use ($record, $interviewSession) {
                            echo Pdf::loadHtml(
                                Blade::render('print.application.application-pdf', ['record' => $record, 'interviewSession' => $interviewSession])
                            )->stream();
                        }, $record->user->name . '-' . $record->jobVacancy->title . '.pdf');
                    }),
                // ->url(fn(Model $reco,rd) => route('applications.print', $record))
                // ->openUrlInNewTab(),
                Action::make('submitApplication')
                    ->label('Ajukan Kandidat')
                    ->icon(LucideIcon::UserRoundPlus)
                    ->schema([
                        Select::make('company')
                            ->label('Perusahaan')
                            ->options(
                                ErpIntegration::query()->pluck('company_name', 'id')
                            )
                    ])
                    ->action(function ($record, array $data) {


                        try {

                            // Ambil konfigurasi ERP
                            $erp = ErpIntegration::findOrFail($data['company']);
                            $application = Application::query()
                                ->with([
                                    'user.applicant',
                                    'applicantTests.attempts.answers',
                                    'applicantTests.attempts.jobVacancyTestItem.test',
                                    'interviewSessionApplications.interviewSession',
                                    'interviewSessionApplications.evaluations.sessionEvaluator.user',
                                    'interviewSessionApplications.evaluations.scores.criteria',
                                    'interviewSessionApplications.evaluations.scores.scaleOption',
                                ])
                                ->findOrFail($record->id);

                            // payload final (array murni)
                            $payload = CandidateSyncApiResource::make($application)
                                ->resolve();

                            // Kirim request ke ERP
                            $debugFile = null;
                            $debugHandle = null;

                            // Try to decrypt token if it's stored encrypted in DB
                            try {
                                $token = decrypt($erp->bearer_token_encrypted);
                            } catch (\Throwable $ex) {
                                $token = $erp->bearer_token_encrypted; // fallback to raw value
                            }

                            // Create a timestamped debug file so we can inspect request/response at cURL level
                            try {
                                $debugFile = storage_path('logs/erp_http_debug_' . now()->format('Ymd_His') . '.log');
                                $debugHandle = @fopen($debugFile, 'w+');
                            } catch (\Throwable $ex) {
                                $debugHandle = null;
                            }

                            $client = Http::withOptions(array_filter([
                                'debug' => $debugHandle ?: null,
                            ]))->withToken($token)
                                ->acceptJson()
                                ->asJson()
                                ->timeout(60);

                            // perform request
                            $response = $client->post(
                                rtrim($erp->base_url, '/') . '/api/v1/candidates',
                                $payload // payload berupa array/json
                            );

                            // close debug handle if opened and log path for visibility
                            if (is_resource($debugHandle)) {
                                fclose($debugHandle);
                                Log::info('ERP HTTP debug written', ['debug_file' => $debugFile]);
                            }

                            $record->update([
                                'is_submitted' => true,
                                'submitted_at' => now(),
                                'submitted_by' => auth()->id(),
                            ]);

                            // Jika response status 4xx/5xx, lempar exception otomatis
                            $response->throw();

                            // ===============================
                            //  SUCCESS
                            // ===============================
                            Notification::make()
                                ->title('Kandidat berhasil diajukan')
                                ->body('Data sudah berhasil dikirim ke ERP ' . $erp->company_name)
                                ->success()
                                ->send();
                        } catch (\Illuminate\Http\Client\RequestException $e) {

                            // HTTP exception → ambil response error
                            $response = $e->response;

                            // Dapatkan detail error JSON jika ada
                            $errorBody = $response?->json() ?: $response?->body();

                            // Simpan log lengkap
                            Log::error('Gagal Ajukan Kandidat ke ERP', [
                                'company' => $erp->company_name,
                                'status' => $response?->status(),
                                'error'  => $errorBody,
                                'payload' => $payload,
                            ]);

                            // Tangani error validasi (422)
                            if ($response?->status() === 422) {
                                return Notification::make()
                                    ->title('Gagal: Validasi ERP')
                                    ->body(json_encode($errorBody['errors'] ?? $errorBody, JSON_PRETTY_PRINT))
                                    ->danger()
                                    ->send();
                            }

                            // Kalau 401/403 → token salah
                            if (in_array($response?->status(), [401, 403])) {
                                return Notification::make()
                                    ->title('Autentikasi gagal')
                                    ->body('Token ERP tidak valid atau tidak punya akses.')
                                    ->danger()
                                    ->send();
                            }

                            // 500 atau server error lainnya — tampilkan pesan lebih spesifik jika tersedia
                            if ($response?->serverError()) {
                                $errorBody = null;
                                try {
                                    $errorBody = $response?->json();
                                } catch (\Throwable $ex) {
                                    $errorBody = $response?->body();
                                }

                                if (is_array($errorBody)) {
                                    $message = $errorBody['message'] ?? $errorBody['error'] ?? json_encode(array_slice($errorBody, 0, 3));
                                } else {
                                    $message = Str::limit((string) $errorBody, 400);
                                }

                                // Log full details for debugging (but avoid logging tokens)
                                Log::error('ERP server error response', [
                                    'company' => $erp->company_name ?? $data['company'] ?? null,
                                    'status' => $response?->status(),
                                    'body' => $errorBody,
                                    'payload_summary' => Str::limit(json_encode($payload ?? []), 1000),
                                ]);

                                return Notification::make()
                                    ->title('Server ERP Bermasalah: ' . ($response?->status() ?? 'Unknown'))
                                    ->body($message)
                                    ->danger()
                                    ->send();
                            }

                            // Default fallback
                            return Notification::make()
                                ->title('Gagal mengirim data')
                                ->body(json_encode($errorBody, JSON_PRETTY_PRINT))
                                ->danger()
                                ->send();
                        } catch (\Throwable $e) {

                            // Kesalahan lain (runtime, network timeout, dsb)
                            Log::error('Kesalahan umum saat mengirim kandidat', [
                                'exception' => $e->getMessage(),
                                'payload' => $payload,
                            ]);

                            return Notification::make()
                                ->title('Terjadi kesalahan')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('createStageProgress')
                        ->label('Tambah Tahap Lamaran')
                        ->icon('heroicon-o-plus')
                        ->schema(function (Collection $records) {
                            return [
                                Select::make('job_vacancy_stage_id')
                                    ->label('Tahap Lamaran')
                                    ->options(
                                        JobVacancyStage::with('stageType')
                                            ->get()
                                            ->mapWithKeys(fn($stage) => [$stage->id => $stage->stageType->name])
                                    )
                                    ->searchable(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options(Status::class),
                                DatePicker::make('started_at')->label('Mulai'),
                                DatePicker::make('decided_at')->label('Selesai'),
                                Select::make('decided_by')
                                    ->label('Diterima Oleh')
                                    ->options(User::pluck('name', 'id')),
                                Textarea::make('note')->columnSpanFull()->label('Catatan'),
                                TextInput::make('score')->label('Skor')->numeric()->minValue(1),
                            ];
                        })
                        ->visible()
                        ->action(function (Collection $records, array $data): void {
                            // Ambil semua job_vacancy_id yang unik dari record terpilih
                            $jobVacancyIds = $records->pluck('job_vacancy_id')->unique();

                            // Kalau lebih dari 1, berarti beda-beda lowongan → batalin aksi
                            if ($jobVacancyIds->count() !== 1) {
                                Notification::make()
                                    ->title('Aksi dibatalkan')
                                    ->body('Silakan pilih lamaran dari lowongan yang sama sebelum menambah tahap lamaran.')
                                    ->danger()
                                    ->send();

                                return; // stop, jangan lanjut create
                            }

                            // Lolos validasi → silakan lanjut proses seperti biasa
                            foreach ($records as $record) {
                                // update stage saat ini di parent
                                $record->update([
                                    'current_stage_id' => $data['job_vacancy_stage_id'],
                                ]);

                                // tambahkan progress baru
                                $record->stageProgresses()->create($data);
                            }

                            Notification::make()
                                ->title('Tahap lamaran berhasil ditambahkan')
                                ->success()
                                ->send();
                        })

                ]),
            ]);
    }
}
