<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Admin;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicAgeGroupRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicEducationRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicGenderRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicReligionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\DemographicService;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;

class DemographicController
{
    private DemographicService $demographicService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $genderRepository = new DemographicGenderRepository($pdo);
        $educationRepository = new DemographicEducationRepository($pdo);
        $religionRepository = new DemographicReligionRepository($pdo);
        $ageGroupRepository = new DemographicAgeGroupRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->demographicService = new DemographicService(
            $genderRepository,
            $educationRepository,
            $religionRepository,
            $ageGroupRepository
        );

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    /**
     * Display demographic dashboard
     */
    public function index(): void
    {
        $summary = $this->demographicService->getDashboardSummary();

        View::renderAdmin('Demographics/demographic', [
            'title' => 'Demografi Desa',
            'current' => 'demographic',
            'user' => $this->sessionService->current(),
            'summary' => $summary,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/admin/dashboard'
                ],
                [
                    'title' => 'Demografi Desa',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Show gender edit form
     */
    /**
     * Show gender edit form
     */
    public function editGender(): void
    {
        $genders = $this->demographicService->getAllGenders();

        View::renderAdmin('Demographics/gender-edit', [
            'title' => 'Edit Data Gender',
            'current' => 'demographic',
            'user' => $this->sessionService->current(),
            'genders' => $genders,
            'breadcrumbs' => [
                [
                    'title' => 'Demografi Desa',
                    'url' => '/admin/demographic'
                ],
                [
                    'title' => 'Edit Gender',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle gender update
     */
    public function postEditGender(): void
    {
        $male = (int) ($_POST['male'] ?? 0);
        $female = (int) ($_POST['female'] ?? 0);

        try {
            // Update data gender
            $this->demographicService->updateGender('Laki-laki', $male);
            $this->demographicService->updateGender('Perempuan', $female);

            $_SESSION['success'] = 'Data gender berhasil diperbarui';
            View::redirect('/admin/demographic');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/demographic/gender/edit');
        }
    }

    /**
     * Show education edit form
     */
    public function editEducation(): void
    {
        $educations = $this->demographicService->getAllEducations();

        View::renderAdmin('Demographics/education-edit', [
            'title' => 'Edit Data Pendidikan',
            'current' => 'demographic',
            'user' => $this->sessionService->current(),
            'educations' => $educations,
            'breadcrumbs' => [
                [
                    'title' => 'Demografi Desa',
                    'url' => '/admin/demographic'
                ],
                [
                    'title' => 'Edit Pendidikan',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
 * Handle education update
 */
public function postEditEducation(): void
{
    try {
        // Hapus semua data lama menggunakan method yang benar
        $this->demographicService->deleteAllEducation();

        // Insert data baru
        if (isset($_POST['education_level']) && is_array($_POST['education_level'])) {
            foreach ($_POST['education_level'] as $index => $level) {
                $level = trim($level);
                $total = isset($_POST['education_total'][$index]) ? (int) $_POST['education_total'][$index] : 0;

                if (!empty($level) && $total >= 0) {
                    $this->demographicService->createEducation($level, $total);
                }
            }
        }

        $_SESSION['success'] = 'Data pendidikan berhasil diperbarui';
        View::redirect('/admin/demographic');
    } catch (ValidationException $e) {
        $_SESSION['error'] = $e->getMessage();
        View::redirect('/admin/demographic/education/edit');
    }
}

    /**
     * Show religion edit form
     */
    public function editReligion(): void
    {
        $religions = $this->demographicService->getAllReligions();

        View::renderAdmin('Demographics/religion-edit', [
            'title' => 'Edit Data Agama',
            'current' => 'demographic',
            'user' => $this->sessionService->current(),
            'religions' => $religions,
            'breadcrumbs' => [
                [
                    'title' => 'Demografi Desa',
                    'url' => '/admin/demographic'
                ],
                [
                    'title' => 'Edit Agama',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle religion update
     */
    public function postEditReligion(): void
    {
        try {
            // Hapus semua data lama
            $this->demographicService->deleteAllReligion(); // <-- Gunakan ini

            // Insert data baru
            if (isset($_POST['religion']) && is_array($_POST['religion'])) {
                foreach ($_POST['religion'] as $index => $religion) {
                    $religion = trim($religion);
                    $total = isset($_POST['religion_total'][$index]) ? (int) $_POST['religion_total'][$index] : 0;

                    if (!empty($religion) && $total >= 0) {
                        $this->demographicService->createReligion($religion, $total);
                    }
                }
            }

            $_SESSION['success'] = 'Data agama berhasil diperbarui';
            View::redirect('/admin/demographic');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/demographic/religion/edit');
        }
    }

    /**
     * Show age group edit form
     */
    public function editAgeGroup(): void
    {
        $ageGroups = $this->demographicService->getAllAgeGroups();

        View::renderAdmin('Demographics/age-group-edit', [
            'title' => 'Edit Data Kelompok Umur',
            'current' => 'demographic',
            'user' => $this->sessionService->current(),
            'ageGroups' => $ageGroups,
            'breadcrumbs' => [
                [
                    'title' => 'Demografi Desa',
                    'url' => '/admin/demographic'
                ],
                [
                    'title' => 'Edit Kelompok Umur',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle age group update
     */
    public function postEditAgeGroup(): void
    {
        try {
            // Hapus semua data lama
            $this->demographicService->deleteAllAgeGroup(); // <-- Gunakan ini

            // Insert data baru
            if (isset($_POST['age_range']) && is_array($_POST['age_range'])) {
                foreach ($_POST['age_range'] as $index => $ageRange) {
                    $ageRange = trim($ageRange);
                    $total = isset($_POST['age_total'][$index]) ? (int) $_POST['age_total'][$index] : 0;

                    if (!empty($ageRange) && $total >= 0) {
                        $this->demographicService->createAgeGroup($ageRange, $total);
                    }
                }
            }

            $_SESSION['success'] = 'Data kelompok umur berhasil diperbarui';
            View::redirect('/admin/demographic');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/demographic/age-group/edit');
        }
    }
}