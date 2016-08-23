<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Excel;
use App\Mandant;
use App\MandantInfo;

class TelephoneListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mandants = Mandant::orderBy('mandant_number')->get();
            foreach($mandants as $k =>$mandant){
                $userArr = array();
                $testuserArr = array();
                foreach($mandant->users as $k2 => $mUser){
                    foreach($mUser->mandantRoles as $mr){
                         $testuserArr[] = $mr->role->name;
                        //  dd($mr->role->phone_role);
                        if( $mr->role->phone_role == 1  || $mr->role->id == 23 || $mr->role->id == 21) //edv
                             $userArr[] = $mandant->users[$k2]->id;
                    }
                    
                    if( count($userArr) < 1){
                        foreach($mUser->mandantRoles as $mr){
                            if( $mr->role->id == 23 )// Lohn
                                $userArr[] = $mandant->users[$k2]->id;
                        }   
                    }
                    if( count($userArr) < 1){
                        foreach($mUser->mandantRoles as $mr){
                            if( $mr->role->name == 'Geschäftsführer' || $mr->role->name == 'Qualitätsmanager' || $mr->role->name == 'Rechntabteilung' 
                            ||  $mr->role->phone_role == true ||  $mr->role->phone_role == 1 )
                                $userArr[] = $mandant->users[$k2]->id;
                        }   
                    }
                    
                }//end second foreach
                $mandant->usersInMandants = $mandant->users->whereIn('id',$userArr);
            }
        return view('telefonliste.index', compact('mandants') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Generate PDF document for the passed Mandant ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdfExport($id)
    {
        $mandant = Mandant::find($id);
        $mandantInfo = MandantInfo::where('mandant_id', $id)->first();
        $hauptstelle = Mandant::find($mandant->mandant_id_hauptstelle);
        
        $pdf = \PDF::loadView('pdf.mandant', compact('mandant','mandantInfo','hauptstelle'));
        return $pdf->stream();
    }
    
    /**
     * Generate XLS document for the passed request parameters
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function xlsExport(Request $request)
    {
        Excel::create('NEPTUN Excel', function($excel){
            
        
            $excel->setTitle('Test Titel');
            $excel->setDescription('Test XLS Beschreibung');
            
            // Add sheet
            $excel->sheet('Blatt 1', function($sheet) {
                
                // Append row after row 2
                $sheet->appendRow(2, array('test 1', 'test 2'));
                
                // Append row as very last
                $sheet->appendRow(array('test 3', 'test 4'));
                
            });
            
            $excel->sheet('Blatt 2', function($sheet) {
                
            });

            
        })->export('xls');
        
    }
    
    
}
