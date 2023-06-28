<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $per_page = $request->per_page ?? 5;
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/calendars/lists",
                'name' => "Calendars List"
            ]
        ];
        $pageTitle = 'Calendars List';
        $users = User::all();
        return view('calendars.lists', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'users' => $users
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
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
