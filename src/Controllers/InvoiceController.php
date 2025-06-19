<?php
namespace Src\Controllers;

class InvoiceController
{
    public function index()
    {
        $stages = [
            ['name' => 'Requirement Gathering', 'color' => '#A7F3D0'],
            ['name' => 'Project Proposal',     'color' => '#5EEAD4'],
            ['name' => 'Design',               'color' => '#BFDBFE'],
            ['name' => 'Development',          'color' => '#E9D5FF'],
            ['name' => 'Integration Testing',  'color' => '#FECACA'],
            ['name' => 'Client Handoff',       'color' => '#DDD6FE'],
        ];

        $invoices = [
            [
                'number' => '20250612-001',
                'cost'   => 10000,
                'tags'   => ['Development'],
                'notes'  => 'Fault tolerant Servers and Network Switches for Server Room A'
            ],
            [
                'number' => '20250701-003',
                'cost'   => 7500,
                'tags'   => ['Design', 'Integration Testing'],
                'notes'  => 'API integration and UI mockup updates'
            ],
            [
                'number' => '20250715-001',
                'cost'   => 5000,
                'tags'   => ['Requirement Gathering'],
                'notes'  => 'Initial requirements workshop and documentation'
            ],
            [
                'number' => '20250715-002',
                'cost'   => 8500,
                'tags'   => ['Project Proposal'],
                'notes'  => 'Proposal creation and presentation to client'
            ],
            [
                'number' => '20250910-001',
                'cost'   => 12000,
                'tags'   => ['Development', 'Client Handoff'],
                'notes'  => 'Final delivery and handoff materials'
            ],
        ];

        include __DIR__ . '/../../views/invoices.php';
    }
}