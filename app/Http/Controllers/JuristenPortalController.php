<?php

namespace App\Http\Controllers;

use Artisan;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Helpers\ViewHelper;

use App\JuristCategory;
use App\JuristCategoryMeta;
use App\JuristCategoryMetaField;
use App\JuristCategoryMetaFieldValues;
use App\JuristFile;
use App\JuristFileAttachment;
use App\JuristFileComment;
use App\JuristFileUpload;
use App\JuristDocumentsMandant;
use App\JuristResubmissionPriority;
use App\JuristFileResubmission;
use App\Document;
use App\EditorVariant;
use App\DocumentUpload;
use App\User;
use App\Role;
use App\MandantUserRole;
use App\MandantUser;
use App\JuristFileType;
use App\JuristFileTypeUser;

use App\Http\Repositories\DocumentRepository;


class JuristenPortalController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct(DocumentRepository $docRepo)
    {
        $this->document = $docRepo;
        $this->uploadPath = public_path().'/files/contacts/';
    
        $this->portalOcrUploads = public_path().'/files/juristenportal/ocr-uploads/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $juristenCategories = JuristCategory::where('beratung',0)->where('parent',1)->where('active',1)->get();
        $juristenCategoriesBeratung = JuristCategory::where('beratung',1)->where('parent',1)->where('active',1)->get();
        
        return view('juristenportal.index', compact('juristenCategories','juristenCategoriesBeratung') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadView()
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $query = Document::whereNull('document_type_id')
        ->orderBy('documents.created_at', 'desc')->limit(50);
        $documentsMy = $query->where(function ($query) {
                $query->where('owner_user_id', Auth::user()->id)
                ->orWhere('user_id', Auth::user()->id);
                $query->orWhereIn('documents.id', [Auth::user()->id]);
         })->paginate(10, ['*'], 'my-dokumente');
        $documentsMyTree = $this->document->generateTreeview($documentsMy, array('pageHome' => true, 'myDocuments' => true, 'noCategoryDocuments' => true,
        'showAttachments' => true, 'showHistory' => true));
       
        $documentsAll = $query->paginate(10, ['*'], 'alle-dokumente');
        $documentsAllTree = $this->document->generateTreeview($documentsAll, array('pageHome' => true, 'myDocuments' => true, 'noCategoryDocuments' => true,
        'showAttachments' => true, 'showHistory' => true));
        // $documentsNew = $this->document->getUserPermissionedDocuments($documentsNew, 'neue-dokumente', array('field' => 'documents.date_published', 'sort' => 'desc'), $perPage = 10);
        // $documentsNewTree = $this->document->generateTreeview($documentsNew, 
        // array('pageHome' => true, 'showAttachments' => true, 'showHistory' => true));

        return view('juristenportal.upload', compact('documentsMy','documentsMyTree','documentsAll','documentsAllTree'));
    }
    
    
       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aktenArt()
    {
        if (ViewHelper::universalHasPermission(array(7, 34)) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $userMandantRoles = MandantUserRole::where('role_id', Role::JURISTBENUTZER )->pluck('mandant_user_id')->toArray();
        $mandantUsers = MandantUser::select('user_id')->whereIn('id',$userMandantRoles)->distinct()->get();
        $users = User::whereIn('id',$mandantUsers->toArray() )->get();
        $juristFileTypes = JuristFileType::all();
        return view('juristenportal.aktenArt', compact('users','juristFileTypes') );
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAktenArt(Request $request)
    {
        // dd( $request->all() );
        $akten =  JuristFileType::create($request->all());
        if( $request->has('users') && count($request->get('users')) ){
            $request->merge(['jurist_file_type_id' => $akten->id]);
            if( in_array('Alle',$request->get('users'))){
                $userMandantRoles = MandantUserRole::where('role_id', Role::JURISTBENUTZER )->pluck('mandant_user_id')->toArray();
                $mandantUsers = MandantUser::select('user_id')->whereIn('id',$userMandantRoles)->distinct()->get();
                $users = User::whereIn('id',$mandantUsers->toArray() )->pluck('id')->toArray();
                $request->merge(['users'=> $users]);
            }
            foreach($request->get('users') as $user){
                 $request->merge(['user_id' => $user]);
                 $aktenArtUsers =  JuristFileTypeUser::create($request->all());
            }
        }
        return redirect()->back()->with('messageSecondary', trans('juristenPortal.savedAktenArt'));
    }
     
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAktenArt(Request $request, $id)
    {
        $fileType = JuristFileType::find($id);
        // dd( $fileType );
         
        if( $request->has('active') ){
            // dd($request->all());
            //  dd($fileType);
            $fileType->active = $request->get('active');
            $fileType->save();
            //  dd($fileType);
           
        }
        $fileType->fill($request->all() )->save();
        $usersBeforeInsert = JuristFileTypeUser::where('jurist_file_type_id',$id)->pluck('user_id')->toArray();
        if(!$request->has('users')){
            $users = $fileType->juristFileTypeUsers;
            foreach($users as $user){
                $user->delete();
            }
        }
        else{
            $request->merge(['jurist_file_type_id' => $id]);
             if( in_array('Alle',$request->get('users'))){
                $userMandantRoles = MandantUserRole::where('role_id', Role::JURISTBENUTZER )->pluck('mandant_user_id')->toArray();
                $mandantUsers = MandantUser::select('user_id')->whereIn('id',$userMandantRoles)->distinct()->get();
                $users = User::whereIn('id',$mandantUsers->toArray() )->pluck('id')->toArray();
                $request->merge(['users'=> $users]);
            }
            
            foreach($request->get('users') as $user){
                $request->merge(['user_id' => $user]);
                JuristFileTypeUser::create($request->all() );
                foreach($usersBeforeInsert as $key=>$dek){
                    if($user == $dek){
                        unset ($usersBeforeInsert[$key]);
                    }
                    
                }
            }
        }
      
        foreach($usersBeforeInsert as $del){
            $delUser = JuristFileTypeUser::where('jurist_file_type_id',$id)->where('user_id',$del)->get();
            foreach($delUser as $dUr){
                $dUr->delete();
            }
        }
        // dd( $request->all() );
       
        return redirect()->back()->with('messageSecondary', trans('juristenPortal.updatedAktenArt'));
    }
    
    public function deleteAktenArt($id)
    {
        $aktenArt = JuristFileType::find($id);
        foreach($aktenArt->juristFileTypeUsers as $usr){
            $usr->delete();
        }
        $aktenArt->delete();
        
        return redirect()->back()->with('messageSecondary', trans('juristenPortal.deletedAktenArt'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function metaInfo()
    {
        if (ViewHelper::universalHasPermission(array(7, 34)) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $categories = JuristCategoryMeta::all();

        return view('juristenportal.metaInfo', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeMetaInfo(Request $request)
    {
        // dd( $request->all() );
        if(!$request->has('name')){
            redirect()->back()->with('messageSecondary', trans('juristenportal.noCategoryName'));
        }
        $category = JuristCategoryMeta::create($request->all());
        // dd($category);
        if($request->has('meta-names') && count($request->get('meta-names'))){
            $request->merge(['jurist_category_meta_id'=> $category->id]);
            foreach($request->get('meta-names') as $meta){
                 $request->merge(['name'=> $meta]);
                 JuristCategoryMetaField::create($request->all());
            }
        }
        
        return redirect()->back()->with('messageSecondary', trans('inventoryList.inventoryAdded'));
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMetaInfo(Request $request, JuristCategoryMeta $juristenCategoryMeta)
    {
        if (ViewHelper::universalHasPermission(array(34)) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
       
        $juristenCategoryMeta->fill($request->all())->save();

        return redirect()->back()->with('messageSecondary', trans('inventoryList.categoryUpdated'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addJuristenCategoryMetaFields(Request $request, JuristCategoryMeta $juristenCategoryMeta)
    {
        $request->merge(['jurist_category_meta_id'=> $juristenCategoryMeta->id]);
        if($request->has('meta-names') && count($request->get('meta-names'))){
            foreach($request->get('meta-names') as $meta){
                 $request->merge(['name'=> $meta]);
                 JuristCategoryMetaField::create($request->all());
            }
        }
        
        return redirect()->back()->with('messageSecondary', trans('inventoryList.inventoryAdded'));
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMetaField(Request $request, $id)
    {
        if (ViewHelper::universalHasPermission(array(34)) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $metaField = JuristCategoryMetaField::find($id);
        $metaField->fill($request->all())->save();
        
        return redirect()->back()->with('messageSecondary', trans('inventoryList.inventoryAdded'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateJuristenCategoryMetaFields(Request $request, JuristCategoryMeta $juristenCategoryMeta)
    {
        $request->merge(['jurist_category_meta_id'=> $juristenCategoryMeta->id]);
        if($request->has('meta-names') && count($request->get('meta-names'))){
            foreach($request->get('meta-names') as $meta){
                 $request->merge(['name'=> $meta]);
                 JuristCategoryMetaField::create($request->all());
            }
        }
        
        return redirect()->back()->with('messageSecondary', trans('inventoryList.inventoryAdded'));
    }
    
     /**
     * Delete the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteJuristenCategoryMeta(JuristCategoryMeta $juristenCategoryMeta)
    {
        if (ViewHelper::universalHasPermission(array(34)) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $juristenCategoryMeta->delete();

        return redirect()->back()->with('messageSecondary', trans('inventoryList.deletedJuristenCategoryMeta'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if (ViewHelper::universalHasPermission(array(35, 36), false) == false) {
            return redirect('/')->with('messageSecondary', trans('documentForm.noPermission'));
        }
        $uploaded = $this->fileUpload($request->file);
        $this->findDuplicates($uploaded);

        if ($uploaded == false) {
            return redirect()->back()->with('messageSecondary', 'Upload fehlgeschlagen');
        }
        else {
            Artisan::call('juristenportal:import');
            return redirect()->back()->with('messageSecondary', 'Dateien hochgeladen');
        }
    }

    /**
     * Find duplicate Files in the database
     * 
     * This function tries to find duplicate files by filename or meta data
     * At first, it will check if a file with the same name exists.
     * If not, then it checks the Author + Title in the Documents Table
     * 
     * Duplicate File will get the file ending .duplicate
     * all other files will be renamed from .processing to their original name
     * 
     * @param array $files Array of fileNames [without the Path]
     * @return array Array with duplicate Files and their original Document Object
     */
    private function findDuplicates(array $files){
        $duplicates = [];
        foreach($files as $filename){
            $ocrHelper = new \App\Helpers\OcrHelper($this->portalOcrUploads, $filename);
            $metaData = $ocrHelper->getMetaData();
            $originalFilename = substr($filename, 0, -11);
            
            $dbDocumentUpload = DocumentUpload::with('editorVariant', 'editorVariant.document', 'editorVariant.document.user')
                                                ->where('file_path', $originalFilename)
                                                ->first();
            if($dbDocumentUpload != null){
                $duplicates[$filename] = ['metadata' => $metaData, 'original' => $dbDocumentUpload->editorVariant->document];
                File::move($this->portalOcrUploads . $filename , $this->portalOcrUploads . $originalFilename . '.duplicate');
                continue;
            }
            
            $user_id = 1;
            $real_user_name = '';
            $title = '';
            
            if(isset($metaData['Last Modified By'])){
                $real_user_name = $metaData['Last Modified By'];
            }else if(isset($metaData['Creator'])){
                $real_user_name = $metaData['Creator'];
            }
            if(isset($metaData['Title'])){
                $title = $metaData['Title'];
            }

            if(($user = User::findByName($real_user_name)) != null){
                $user_id = $user->id;
            }
            
            $document = Document::where('name', $title)
                                 ->where('user_id', $user_id)
                                 ->first();
            if($document != null){
                 $duplicates[$filename] = ['metadata' => $metaData, 'original' => $document];
                 File::move($this->portalOcrUploads . $filename , $this->portalOcrUploads . $originalFilename . '.duplicate');
                 continue;
            }

            File::move($this->portalOcrUploads . $filename , $this->portalOcrUploads . $originalFilename);
        }
        return $duplicates;
    }

    /**
     * Process files for upload.
     *
     * @param array $files
     *
     * @return \Illuminate\Http\Response
     */
    private function fileUpload($files)
    {
        $folder = $this->portalOcrUploads;
        $uploadedNames = array();
        if (!\File::exists($folder)) {
            \File::makeDirectory($folder, $mod = 0777, true, true);
        }
        if (is_array($files)) {
           //  dd($files);
            foreach ($files as $k => $file) {
                 if (ViewHelper::fileTypeAllowed($file)) {
                        $uploadedNames[] = $this->moveUploaded($file, $folder);
                }
            }
        } else {
            if (ViewHelper::fileTypeAllowed($files)) {
                $uploadedNames[] = $this->moveUploaded($files, $folder);
            }
        }

        if (count($uploadedNames)) {
            return $uploadedNames;
        } else {
            return false;
        }
    }

    /**
     * Move files from temp folder and rename them.
     *
     * @param file object $file
     * @param string      $folder
     *
     * @return string $newName
     */
    private function moveUploaded($file, $folder, $counter = 0)
    {
        $filename = $file->getClientOriginalName();
        $newName = $filename . '.processing';
        $uploadSuccess = $file->move($folder, $newName);
        \File::delete($folder.'/'.$filename);

        return $newName;
    }
    
    /**
     * BEGIN: BERATUNGSPORTAL CALENDAR
     * 
     * load all users who have a record and record status != erledig (id:4)
     */ 
    private function loadUserWhithRecord()
    {
        $users = User::where('active', 1)
                        ->join('jurist_file_resubmissions', function($join){
                          $join->on('users.id', '=', 'jurist_file_resubmissions.sender_id');
                          $join->on('jurist_file_resubmission_status_id', '!=', \DB::raw(4));
                        })
                        ->addSelect('users.id as id')
                        ->addSelect('users.username as username')
                        ->addSelect('users.last_name as last_name')
                        ->addSelect('users.first_name as first_name')
                        ->groupby('users.id')
                        ->get();
                    
        return $users;
    }
     
     /** 
     * load Auth::user data
     */
    public function viewCalendar()
    {
        $data = Auth::user();
        $users = $this->loadUserWhithRecord();
        return view('juristenportal.calendar', compact('users', 'data'));
    }
    
    /**
     * load all calendar data for one month who status != erledig (id:4)
     */
    private function loadOneMonth($request)
    {
        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));
         
        $documents = JuristFileResubmission::where('sender_id', $request->user_id)
                        ->where('jurist_file_resubmission_status_id', '!=', '4')
                        ->join('jurist_files', 'jurist_file_id', '=', 'jurist_files.id')
                        ->addSelect('jurist_files.name as jurist_file_name')
                        ->addSelect('jurist_file_resubmissions.id as jfr_id')
                        ->addSelect('jurist_file_resubmissions.date_available as jfr_date')
                        
                        ->join('jurist_resubmission_priorities', 'jurist_resubmission_priority_id', '=', 'jurist_resubmission_priorities.id')
                        ->addSelect('jurist_resubmission_priorities.color as color')
                        ->addSelect('jurist_resubmission_priorities.bgcolor as bgcolor')
                        
                        ->join('jurist_file_resubmission_status', 'jurist_file_resubmissions.jurist_file_resubmission_status_id', '=', 'jurist_file_resubmission_status.id')
                        ->addSelect('jurist_file_resubmission_status.name as statusName')
                        
                        ->whereBetween('date_available', [$start, $end])
                        ->get();
                        
        foreach($documents as $document){
            $event[] = array(
                'id' => $document->jfr_id,
                'title' => $document->jurist_file_name . ', ' . $document->statusName,
                'start' => date('Y-m-d', strtotime($document->jfr_date)),
                'color' => $document->color,
                'bgcolor' => $document->bgcolor
            );
         }                
                        
        return $event;
    }

    /**
     * load selected user data
     * click on button whit user
     */
    public function viewUserCalendar(Request $request)
    {
        $data = User::find($request->id);
        $users = $this->loadUserWhithRecord();
        $startdate = $request->starViewtDate;
        
        return view('juristenportal.calendar', compact('users', 'data', 'startdate'));
    }
    
    /**
     * click next or prev month
     */    
    public function viewNextMonth(Request $request)
    {
        $event = $this->loadOneMonth($request);
        return response()->json($event, 200);
    }
    
    /**
     * END: BERATUNGSPORTAL CALENDAR
     */ 
    

}
