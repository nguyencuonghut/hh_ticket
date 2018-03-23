<?php

namespace App\Http\Requests\Troubleshoot;

use Illuminate\Foundation\Http\FormRequest;

class StoreTroubleshootRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'troubleshooter_id' => 'required',
            'deadline' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu bạn PHẢI điền "Tên biện pháp khắc phục"',
            'troubleshooter_id.required' => 'Yêu cầu bạn PHẢI điền "Người thực hiện"',
            'deadline.required' => 'Yêu cầu bạn PHẢI điền "Thời Hạn"',
        ];
    }
}
