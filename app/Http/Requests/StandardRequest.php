<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/23/2015
 * Time: 2:46 PM
 */

namespace StudentInfo\Http\Requests;


class StandardRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *

     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}