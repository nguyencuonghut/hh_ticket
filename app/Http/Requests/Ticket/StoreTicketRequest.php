<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'title' => 'required|unique:tickets',
            'deadline' => 'required',
            'source_id' => 'required',
            'what' => 'required',
            'why' => 'required',
            'who' => 'required',
            'where' => 'required',
            'how_1' => 'required',
            'how_2' => 'required',
            'manager_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Yêu cầu bạn PHẢI điền "Tiêu Đề"',
            'title.unique' => '"Tiêu Đề" đã tồn tại. Vui lòng chọn "Tiêu Đề" khác',
            'deadline.required' => 'Yêu cầu bạn PHẢI điền "Thời Hạn"',
            'source_id.required' => 'Yêu cầu bạn PHẢI điền "Nguồn Gốc"',
            'what.required' => 'Yêu cầu bạn PHẢI điền "Cái gì đã xảy ra?"',
            'why.required' => 'Yêu cầu bạn PHẢI điền "Tại sao đây là một vấn đề?"',
            'who.required' => 'Yêu cầu bạn PHẢI điền "Ai phát hiện ra?"',
            'when.required' => 'Yêu cầu bạn PHẢI điền "Nó xảy ra khi nào?"',
            'where.required' => 'Yêu cầu bạn PHẢI điền "Phát hiện ra ở đâu?"',
            'how_1.required' => 'Yêu cầu bạn PHẢI điền "Bằng cách nào?"',
            'how_2.required' => 'Yêu cầu bạn PHẢI điền "Có bao nhiêu sự không phù hợp?"',
            'manager_id.required' => 'Yêu cầu bạn PHẢI điền "Trưởng bộ phận (nơi xảy ra SKPH)"',
        ];
    }
}
