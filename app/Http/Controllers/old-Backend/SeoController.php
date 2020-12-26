<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Seo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seo_show(Request $request)
    {
        // load seo page
        if($request->main_menu==null && $request->sub_menu==null){
        
            $data['menu'] = 'seo';
            $data['sub_menu'] = $request->seo_menu;
            $data['data'] = Seo::where('menu_name', $request->seo_menu)->first();
            $data['title'] = 'SEO ' . $data['data']->menu_title;
            return view('backend.seo.edit_seo', $data);
        
        // load content part
        } elseif ($request->main_menu!=null && $request->sub_menu!=null && $request->section) {
            $data['menu'] = $request->main_menu;
            $data['sub_menu'] = $request->sub_menu;
            $data['data'] = Seo::where('menu_name', $request->seo_menu)->first();
            $data['title'] = 'Content ' . $request->sub_menu;
            if($request->section == 'header')
                return view('backend.seo.header_edit_seo', $data);
            return view('backend.seo.footer_edit_seo', $data);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function seo_update(Request $request, $menu)
    {
        try {
            $data = Seo::where('menu_name', $menu)->first();
            if($request->has('menu_title')){
                $data->menu_title = $request->menu_title;
            }
            if($request->has('meta_title')){
                $data->meta_title = $request->meta_title;
            }
            if($request->has('meta_desc')){
                $data->meta_desc = $request->meta_desc;
            }
            if($request->has('meta_key')){
                $data->meta_key = $request->meta_key;
            }
            if($request->has('header_code')){
                $data->header_code = $request->header_code;
            }
            if($request->has('post_title')){
                $data->post_title = $request->post_title;
            }
            if($request->has('post_desc')){
                $data->post_desc = $request->post_desc;
            }
            if($request->has('footer_title')){
                $data->footer_title = $request->footer_title;
            }
            if($request->has('footer_desc')){
                $data->footer_desc = $request->footer_desc;
            }
            if($request->has('footer_title_2')){
                $data->footer_title_2 = $request->footer_title_2;
            }
            if($request->has('footer_desc_2')){
                $data->footer_desc_2 = $request->footer_desc_2;
            }
            $data->save();
            Toastr::success('Successfully Updated', 'Success');
            return redirect()->back();
        }catch (\ModelNotFoundException $e) {
            Toastr::error("$e->getMessage()", 'Error');
            return redirect()->back();
        }
    }
    
}