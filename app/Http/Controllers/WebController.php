<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function store(Request $request){
                      
        if($request->session()->has('user_details')){
            $details = $request->session()->get('user_details');
        }else {
            $details = [];
        }
        $count = count($details);        
        if($count > 0){
            foreach($details as $keys => $values){
                $ids = [$values['id']]; 
            }
        }
        $id = isset($ids) ? max($ids) : 0;         
        $imageName = time().'_'.rand(999,9999).'.'.$request->file->extension();  
        $request->file->move(public_path('users'), $imageName);
        $data = [
            'id' => $id+1,
            'name' => $request->name,
            'image' => $imageName,
            'address' => $request->address,                    
            'gender' => $request->gender,                    
        ]; 
        array_push($details,$data);       
        $request->session()->put('user_details', $details);
        return response()->json([
            'msg' => 'successfull', 
            'data' =>  $details         
        ]);

    }

    public function delete(Request $request){
        if ($request->session()->has('user_details')) {
            $user_data = $request->session()->get('user_details'); 
            // unset($user_data[$request->key]);
            // $new_collection = array_values($user_data);  
            $new_collection = [];                    
            foreach ($user_data as $item) {                          
                if ($item['id'] !=  $request->key) {
                    array_push($new_collection,$item);
                }
            }                      
            $request->session()->put('user_details', $new_collection);           
        }

        return response()->json([
            'msg' => 'successfull', 
            'data' =>  $new_collection         
        ]);

    }

    public function edit(Request $request){
        if($request->session()->has('user_details')){
            $details = $request->session()->get('user_details');
            foreach ($details as $item) {                          
                if ($item['id'] ==  $request->id) {
                    $data = $item;
                }
            } 
            
            return response()->json([
                'success' => 1,
                'view' => view('modal.edit_modal',compact('data'))->render(),
            ]); 
        }
        
    }

    public function update(Request $request){
                             
        if ($request->session()->has('user_details')) {
            $user_data = $request->session()->get('user_details');                          
            // $new_collection = [];    
            $item_id_list = array_column($user_data, 'id');
                        
            if(in_array($request->id,$item_id_list)){
                foreach ($user_data as $key => $item) { 
                    // if($item['id'] !=  $request->id){
                    //     array_push($new_collection,$item);
                    // }                    
                    if ($user_data[$key]['id'] ==  $request->id) {
                        if($request->has('file')){
                            $imageName = time().'_'.rand(999,9999).'.'.$request->file->extension();  
                            $request->file->move(public_path('users'), $imageName);                        
                        }else {
                            $imageName = $item['image'];
                        } 
                        $user_data[$key]["id"] =  $request->id;                   
                        $user_data[$key]["name"] =  $request->name;                   
                        $user_data[$key]["image"] =  $imageName;                   
                        $user_data[$key]["address"] =  $request->address;                   
                        $user_data[$key]["gender"] =  $request->gender;                   
                        // $item['id'] = $request->id;
                        // $item['name'] = $request->name;
                        // $item['image'] = $imageName;
                        // $item['address'] = $request->address;
                        // $item['gender'] = $request->gender;                     
                        // $data = [
                        //     'id' => $request->id,
                        //     'name' => $request->name,
                        //     'image' => $imageName,
                        //     'address' => $request->address,                    
                        //     'gender' => $request->gender,                    
                        // ]; 
                        
                        // array_replace($user_data,$item);
                    }                   
                } 
            }
                          
            
            // print_r($item);
            // print_r($user_data);
            
            $request->session()->put('user_details', $user_data); 
            return response()->json([
                'msg' => 'successfull', 
                'data' =>  $user_data         
            ]);          
        }
    }

    public function get_data(Request $request){
        if ($request->session()->has('user_details')) {
            $user_data = $request->session()->get('user_details'); 
            // unset($user_data[$request->key]);
            // $new_collection = array_values($user_data);                                          
        }

        return response()->json([
            'msg' => 'successfull', 
            'data' =>  $user_data         
        ]);
    }
}
