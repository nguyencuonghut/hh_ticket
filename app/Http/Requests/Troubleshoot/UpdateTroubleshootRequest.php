<?php

namespace App\Http\Requests\Troubleshoot;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTroubleshootRequest extends FormRequest
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
            'deadline' => 'required',
            'status_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu bạn PHẢI điền "Tên biện pháp khắc phục"',
            'deadline.required' => 'Yêu cầu bạn PHẢI điền "Thời Hạn"',
            'status_id.required' => 'Yêu cầu bạn PHẢI điền "Trạng thái"',
        ];
    }
}
