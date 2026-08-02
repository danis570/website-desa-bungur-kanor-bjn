<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicAgeGroupRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicEducationRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicGenderRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicReligionRepository;

class DemographicController
{
    private DemographicGenderRepository $genderRepository;
    private DemographicEducationRepository $educationRepository;
    private DemographicReligionRepository $religionRepository;
    private DemographicAgeGroupRepository $ageGroupRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $this->genderRepository = new DemographicGenderRepository($pdo);
        $this->educationRepository = new DemographicEducationRepository($pdo);
        $this->religionRepository = new DemographicReligionRepository($pdo);
        $this->ageGroupRepository = new DemographicAgeGroupRepository($pdo);
    }

    /**
     * Display demographics page
     */
    public function index(): void
    {
        // Get all data
        $genders = $this->genderRepository->findAll();
        $educations = $this->educationRepository->findAll();
        $religions = $this->religionRepository->findAll();
        $ageGroups = $this->ageGroupRepository->findAll();

        // Format data for charts
        $genderData = $this->formatGenderData($genders);
        $educationData = $this->formatEducationData($educations);
        $religionData = $this->formatReligionData($religions);
        $ageData = $this->formatAgeData($ageGroups);

        View::renderPublic('Demographics/demographics', [
            'title' => 'Demografi Desa',
            'current' => 'demographics',
            'genderData' => $genderData,
            'educationData' => $educationData,
            'religionData' => $religionData,
            'ageData' => $ageData
        ]);
    }

    /**
     * Format gender data for chart
     */
    private function formatGenderData(array $genders): array
    {
        $data = [
            'labels' => [],
            'values' => [],
            'colors' => ['#15803d', '#22c55e']
        ];

        foreach ($genders as $gender) {
            $data['labels'][] = $gender->gender;
            $data['values'][] = $gender->total;
        }

        return $data;
    }

    /**
     * Format education data for chart
     */
    private function formatEducationData(array $educations): array
    {
        $colors = [
            '#15803d', '#22c55e', '#16a34a', '#84cc16', '#f59e0b',
            '#f97316', '#ef4444', '#8b5cf6', '#0ea5e9'
        ];

        $data = [
            'labels' => [],
            'values' => [],
            'colors' => []
        ];

        foreach ($educations as $index => $education) {
            $data['labels'][] = $education->educationLevel;
            $data['values'][] = $education->total;
            $data['colors'][] = $colors[$index % count($colors)];
        }

        return $data;
    }

    /**
     * Format religion data for chart
     */
    private function formatReligionData(array $religions): array
    {
        $colors = [
            '#15803d', '#0ea5e9', '#f59e0b', '#ef4444', '#8b5cf6',
            '#22c55e', '#f97316'
        ];

        $data = [
            'labels' => [],
            'values' => [],
            'colors' => []
        ];

        foreach ($religions as $index => $religion) {
            $data['labels'][] = $religion->religion;
            $data['values'][] = $religion->total;
            $data['colors'][] = $colors[$index % count($colors)];
        }

        return $data;
    }

    /**
     * Format age group data for chart
     */
    private function formatAgeData(array $ageGroups): array
    {
        $colors = [
            '#15803d', '#22c55e', '#16a34a', '#84cc16', '#f59e0b',
            '#f97316', '#ef4444'
        ];

        $data = [
            'labels' => [],
            'values' => [],
            'colors' => []
        ];

        foreach ($ageGroups as $index => $ageGroup) {
            $data['labels'][] = $ageGroup->ageRange;
            $data['values'][] = $ageGroup->total;
            $data['colors'][] = $colors[$index % count($colors)];
        }

        return $data;
    }
}