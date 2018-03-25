<?php

namespace App\Http\Requests\Prevention;

use Illuminate\Foundation\Http\FormRequest;

class StorePreventionRequest extends FormRequest
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
            'budget' => 'required',
            'preventor_id' => 'required',
            'where' => 'required',
            'when' => 'required',
            'how' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Yêu cầu bạn PHẢI điền "Tên biện pháp khắc phục"',
            'budget.required' => 'Yêu cầu bạn PHẢI điền "Ngân sách"',
            'preventor_id.required' => 'Yêu cầu bạn PHẢI điền "Ai làm?"',
            'where.required' => 'Yêu cầu bạn PHẢI điền "Làm ở đâu?',
            'when.required' => 'Yêu cầu bạn PHẢI điền "Làm khi nào?"',
            'how.required' => 'Yêu cầu bạn PHẢI điền "Làm như thế nào?"',
        ];
    }
}
