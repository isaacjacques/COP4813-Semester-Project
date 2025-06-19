<?php
namespace Src\Controllers;

class StageController
{

    public function index()
    {
        // Placeholder data, replace with real DB logic later.
        $stages = [
            [
                'name'      => 'Requirement Gathering',
                'allocated' => 6500,
                'deadline'  => '2025-06-30',
                'color'     => '#A7F3D0'
            ],
            [
                'name'      => 'Project Proposal',
                'allocated' => 6500,
                'deadline'  => '2025-07-15',
                'color'     => '#5EEAD4'
            ],
            [
                'name'      => 'Design',
                'allocated' => 27777,
                'deadline'  => '2025-08-01',
                'color'     => '#BFDBFE'
            ],
            [
                'name'      => 'Development',
                'allocated' => 50000,
                'deadline'  => '2025-10-15',
                'color'     => '#E9D5FF'
            ],
            [
                'name'      => 'Integration Testing',
                'allocated' => 25000,
                'deadline'  => '2025-11-01',
                'color'     => '#FECACA'
            ],
            [
                'name'      => 'Client Handoff',
                'allocated' => 2500,
                'deadline'  => '2025-12-01',
                'color'     => '#DDD6FE'
            ]
        ];

        // Render the stages view
        include __DIR__ . '/../../views/stages.php';
    }


    public function save()
    {
        // In a real app: validate $_POST, save to database, redirect back to index
        // For now, just simulate a redirect:
        header('Location: /public/index.php?route=stages');
        exit;
    }
}
