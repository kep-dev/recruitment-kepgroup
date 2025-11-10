<?php

namespace App\Filament\Widgets;

use App\Models\JobVacancy;
use Filament\Widgets\Widget;
use App\Models\ApplicantAnswer;
use App\Models\ApplicantTestAttempt;
use Livewire\Attributes\Computed;
use App\Models\JobVacancyTestItem;

class CorrectWidget extends Widget
{
    protected string $view = 'filament.widgets.correct-widget';

    public $applicantTestAttemptId = null;

    #[Computed]
    public function correctAnswers()
    {
        return ApplicantAnswer::query()
            ->when($this->applicantTestAttemptId, fn ($query) => $query->where('applicant_test_attempt_id', $this->applicantTestAttemptId)->where('is_correct', true))
            ->count();
    }

    #[Computed]
    public function falseAnswers()
    {
        return ApplicantAnswer::query()
            ->when($this->applicantTestAttemptId, fn ($query) => $query->where('applicant_test_attempt_id', $this->applicantTestAttemptId)->where('is_correct', false))
            ->count();
    }

    #[Computed]
    public function noAnswers()
    {
        return ApplicantAnswer::query()
            ->when($this->applicantTestAttemptId, fn ($query) => $query->where('applicant_test_attempt_id', $this->applicantTestAttemptId)->whereNull('selected_choice_id'))
            ->count();
    }

    #[Computed]
    public function totalQuestions()
    {
        $jobVacancyTestItemId = ApplicantTestAttempt::find($this->applicantTestAttemptId)->job_vacancy_test_item_id;

        return JobVacancyTestItem::query()
            ->where('id', $jobVacancyTestItemId)
            ->first()
            ->number_of_question;
    }
}
