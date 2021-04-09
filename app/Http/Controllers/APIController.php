<?php

namespace App\Http\Controllers;

use App\User;
use App\Fileupload;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\FileUploadController;


class APIController extends Controller {

    public function __construct() {
        $this->middleware('jwt-auth');
    }

    public function index() {
        $data['status'] = true;
        $data['Users'] = User::all();
        return response()->json(compact( 'data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:Users',
                'phone' => 'required|numeric',
                'emp_id' => 'required|numeric',
                'company' => 'required | string',
                'location' => 'required | string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
            } else {
                $data = $request->All();
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'emp_id' => $data['emp_id'],
                    'company' => $data['company'],
                    'location' => $data['location'],
                ]);
                return response()->json(array('status' => true, 'msg' => 'Successfully Created'), 200);
            }
        } catch (\Exception $e) {
            return response()->json(array('message' => 'could_not_create_User'), 500);
        }
    }

    public function show($id)
    {
        try {
            $User = User::where('id', $id)->first();
            if ($User != null) {
                return response()->json(array('status' => true, 'User' => $User), 200);
            } else {
                return response()->json(array('message' => 'User_not_found'), 200);
            }
        } catch (\Exception $e) {
            return response()->json(array('message' => 'could_not_create_User'), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $User = User::where('id', $id)->first();
            $data = $request->All();
            if ($User != null) {
                User::where('id', $id)->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]);
            } else {
                return response()->json(array('message' => 'User_not_found'), 200);
            }
            return response()->json(array('status' => true, 'message' => 'updated_User'), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => 'could_not_update_User'), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $User = User::where('id', $id)->first();
            if ($User != null) {
                User::where('id', $id)->delete();
            } else {
                return response()->json(array('message' => 'User_not_found'), 200);
            }
            return response()->json(array('status' => true, 'message' => 'User_deleted'), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => 'could_not_update_User'), 500);
        }
    }

    public function fileupload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        $data = $request->all();
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()->all()]);
        } else {
            if (isset($data['file'])) {
                $file = $data['file'];
                unset($data['file']);
                $data['name'] = FileUploadController::fileUpload($file, 'uploads/students');
            }
            Fileupload::create($data);
            return response()->json(array('status' => true, 'msg' => 'Successfully created'), 200);
        }
    }

    public function fileAPI(){
        $data['files'] = Fileupload::all();
        return response()->json(compact( 'data'));
    }

    public function filedelete($id)
    {
        try {
            $User = Fileupload::where('id', $id)->first();
            if ($User != null) {
                Fileupload::where('id', $id)->delete();
            } else {
                return response()->json(array('message' => 'file_not_found'), 200);
            }
            return response()->json(array('status' => true, 'message' => 'file_deleted'), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => 'could_not_file'), 500);
        }
    }
}
