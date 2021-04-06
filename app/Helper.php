<?php


namespace App;


use App\Models\Language;
use Carbon\Carbon;

/**
 * Class Helper
 * @package App
 */
class Helper
{
    /**
     * @return mixed|string
     */
    public static function getSubDomain()
    {
        return explode('.', $_SERVER['HTTP_HOST'])[0];
    }

    public static function getDomainSendRequest()
    {
        if (array_key_exists("HTTP_ORIGIN", $_SERVER)) {
            return explode('.', explode('//', $_SERVER['HTTP_ORIGIN'])[1])[0];
        } else {
            return "admin";
        }
    }


    /**
     * store new image and delete old image in storage, save only name in database
     * return filename
     *
     * @param $old_img
     * @param $image
     * @param $base_path
     * @return string|null
     */
    public static function saveImage($old_img, $image, $base_path)
    {
        $filename = null;
        $folder = 'storage/';

        if (!is_null($old_img)) {
            $old_file_path = public_path($folder . $base_path . '/' . $old_img);
            $filename = $old_img;

            // if (file_exists($old_file_path)) {
            //     unlink($old_file_path);
            // }
        }

        if (!is_null($image)) {
            $time = Carbon::now()->format('Y-m-d-h-i-s');
            $filename = $time . uniqid() . '.' . pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION );
            // $image->storeAs($base_path, $filename, 'public');
            $image->move($folder . $base_path, $filename);

            if (isset($old_file_path) && file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }

        return $filename;
    }

    /**
     * @param $request
     * @param $lang_vi
     * @param $lang_en
     * @param $field
     * @return |null
     */
    public static function createLanguage($request, $lang_vi, $lang_en, $field)
    {
        if ($request->has($lang_vi) || $request->has($lang_en)) {
            return Language::create([
                'vi' => $request->get($lang_vi),
                'en' => $request->get($lang_en),
                'field' => $field
            ]);
        }

        return null;
    }

    /**
     *
     * extract multiple language field by array in request
     *
     * @param $request_item
     * array request field
     * @param $lang_array
     * array language attribute of a model
     * @param $model_name
     * @return array
     * return array map to create new model [[field_n => lang_id_n],...]
     */
    public static function createLanguageForArrayField($request_item, $lang_array, $model_name)
    {
        $all_attribute_create = [];

        foreach ($lang_array as $field){
            $lang = self::saveLanguageByArrayRequestItem(
                new Language(),
                $request_item,
                $field . '_vi',
                $field . '_en',
                $model_name . '.' . $field
            );
            if ($lang != null)
                $all_attribute_create[$field] = $lang->id;
        }

        return $all_attribute_create;
    }

    /**
     * model has multiple language field
     * update existed language field or create a new one
     *
     * @param $request_item
     * @param $lang_array
     * @param $model
     *
     */
    public static function updateLanguageForArrayField($request_item, $lang_array, $model){
        foreach ($lang_array as $field){
            $model_field_lang_id = $model->$field;
            if ($model_field_lang_id == null) {
                $lang = self::saveLanguageByArrayRequestItem(
                    new Language(),
                    $request_item,
                    $field . '_vi',
                    $field . '_en',
                    $field
                );

                if ($lang !== null) {
                    $model->field = $lang->id;
                    $model->save();
                }
            } else {
                $lang = Language::findOrFail($model_field_lang_id);
                self::saveLanguageByArrayRequestItem(
                    $lang,
                    $request_item,
                    $field . '_vi',
                    $field . '_en',
                    $field
                );
            }
        }
    }

    /**
     *
     * request item or all request
     * request item : array
     * all request : object
     * @param $lang
     * @param $request_item
     * @param $key_vi
     * @param $key_en
     * @param $field
     * @return null
     */
    public static function saveLanguageByArrayRequestItem($lang, $request_item, $key_vi, $key_en, $field){
        $isModify = false;
        if(gettype($request_item) === "array" && array_key_exists($key_vi,$request_item)){
            $lang->vi = $request_item[$key_vi];
            $isModify = true;
        }elseif (gettype($request_item) === "object"){
            //request item is all request
            if($request_item->get($key_vi) !== null){
                $lang->vi = $request_item->get($key_vi);
                $isModify = true;
            }
        }

        if(gettype($request_item) === "array" && array_key_exists($key_en,$request_item)){
            $lang->en = $request_item[$key_en];
            $isModify = true;
        }elseif (gettype($request_item) === "object"){
            if($request_item->get($key_en) !== null){
                $lang->en = $request_item->get($key_en);
                $isModify = true;
            }
        }
        if($isModify){
            $lang->field = $field;
            $lang->save();
            return $lang;
        }
        return null;
    }

    /**
     *
     * @param $request
     * @param $model
     * @param $attribute
     * @param $lang_vi
     * @param $lang_en
     * @param $field
     * @return Language|null
     */
    public static function updateLanguage($request, $model, $attribute, $lang_vi, $lang_en, $field){
        if($request->has($lang_vi) || $request->has($lang_en)){
            $lang = new Language();
            if($model->$attribute != null){
                $lang =  Language::findOrFail($model->$attribute);
            }
            $lang->vi = $request->get($lang_vi);
            $lang->en = $request->get($lang_en);
            $lang->field = $field;
            $lang->save();

            return $lang;
        }
        return null;
    }

    /**
     *  use App\Http\Requests\
     *  use App\Helper
     *  App\Helper::ruleToMessage(CourseOfflineRequest::rules())
     *
     * @param $map
     * @return array
     */
    public static function ruleToMessage($map){
        $data =[];
        $data_msg = [];
        foreach($map as $key => $value){
            $data_msg[$key] = [];
            $rules = explode ('|',$value);
            foreach($rules as $rule){
                $rule = explode(':',$rule)[0];
                if($rule == 'nullable'){
                    continue;
                }
                $data_rule = $key.'.'.$rule;
                $data_message = '';
                $data_msg[$key][$rule] = $data_message;
                $data[$data_rule] = $data_message;
            }
        }
        return [$data, $data_msg];
    }
}
