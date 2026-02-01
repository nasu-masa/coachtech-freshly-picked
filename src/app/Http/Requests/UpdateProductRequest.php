<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * チェックボックスの hidden により、未選択でも season[] = "" が送信される。
     * 空文字が1件でも入っていると Laravel は「値が1件ある」と判定し、
     * required が正しく発火しないため、空文字・null を除去して空配列に正規化する。
     */
    protected function prepareForValidation()
    {
        if ($this->has('season')) {
            $clean = collect($this->season)
                ->filter(fn($v) => $v !== '' && $v !== null) // 空文字・null を除去
                ->values()                                   // 空配列として扱わせるためにキーを詰め直す
                ->toArray();

            $this->merge([
                'season' => $clean,
            ]);
        }
    }

    /**
     * 商品詳細・更新画面バリデーションルール
     */
    public function rules()
    {
        return [
            'name'        => ['required'],
            'price'       => ['required', 'integer', 'min:0', 'max:10000'],
            'image'       => ['required', 'mimes:png,jpeg'],
            'season'      => ['required'],
            'description' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => '商品名を入力してください。',
            'price.required'       => '値段を入力してください。',
            'price.integer'        => '数値で入力してください。',
            'price.min'            => '0〜10000円以内で入力してください。',
            'price.max'            => '0〜10000円以内で入力してください。',
            'image.required'       => '商品画像を登録してください。',
            'image.mimes'          => '「.png」または「.jpeg」形式でアップロードしてください。',
            'season.required'      => '季節を選択してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max'      => '120文字以内で入力してください。',
        ];
    }
}
