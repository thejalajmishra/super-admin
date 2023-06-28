<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $output = [];
        // exec('wmic cpu get loadpercentage', $output);

        // $cpuUsage = trim($output[1]); // Extract the CPU usage percentage

        // echo "CPU Usage: $cpuUsage%";

        // $output = [];
        // exec('wmic logicaldisk get deviceid,freespace,size', $output);

        // $diskUsage = [];

        // foreach ($output as $index => $line) {
        //     if ($index > 0 && !empty($line)) {
        //         $data = preg_split('/\s+/', $line);
        //         $device = $data[0];
        //         $freeSpace = $data[1];
        //         $totalSize = $data[2];

        //         $diskUsage[$device] = [
        //             'freeSpace' => $freeSpace,
        //             'totalSize' => $totalSize,
        //         ];
        //     }
        // }

        // // Print disk usage information
        // foreach ($diskUsage as $device => $usage) {
        //     $freeSpace = $usage['freeSpace'];
        //     $totalSize = $usage['totalSize'];

        //     echo "Device: $device\n";
        //     echo "Free Space: convertToReadableSize($freeSpace) bytes\n";
        //     echo "Total Size: convertToReadableSize($totalSize) bytes\n";
        //     echo "-----------------------\n";
        // }

        // echo ByteUnits\parse('1.42MB')->add($totalSize)->format('kB/0000');

        // exit;

        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ]
        ];
        $pageTitle = 'Dashboard';
        return view('dashboard', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
