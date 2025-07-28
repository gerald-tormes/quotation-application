<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class IndexItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'nullable|string',
            'type' => 'nullable|string',
            'search' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'sortField' => 'nullable|string|in:name,category,type,created_at',
            'sortDirection' => 'nullable|string|in:asc,desc',
            'perPage' => 'nullable|integer|min:1|max:100',
        ];
    }
    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'category.string' => 'The category must be a string.',
            'type.string' => 'The type must be a string.',
            'search.string' => 'The search term must be a string.',
            'search.max' => 'The search term may not be greater than 255 characters.',
            'active.boolean' => 'The active field must be true or false.',
            'sortField.string' => 'The sort field must be a string.',
            'sortField.in' => 'The selected sort field is invalid.',
            'sortDirection.string' => 'The sort direction must be a string.',
            'sortDirection.in' => 'The selected sort direction is invalid.',
            'perPage.integer' => 'The per page value must be an integer.',
            'perPage.min' => 'The per page value must be at least 1.',
            'perPage.max' => 'The per page value may not be greater than 100.',
        ];
    }


    /**
     * Retrieve filter parameters for querying items.
     *
     * @return array<string, mixed>
     *   - category: string|null
     *   - type: string|null
     *   - search: string
     *   - active: bool
     */
     public function getFilters(): array
    {
        return [
            'category' => $validated['category'] ?? null,
            'type' => $validated['type'] ?? null,
            'search' => $validated['search'] ?? '',
            'active' => $validated['active'] ?? true,
        ];
    }

    /**
     * Retrieve sorting parameters for querying items.
     *
     * @return array<string, string>
     *   - field: string (default: 'name')
     *   - direction: string (default: 'asc')
     */
     public function getSorting(): array
    {
        return [
            'field' => $this->input('sortField', 'name'),
            'direction' => $this->input('sortDirection', 'asc'),
        ];
    }

    /**
     * Retrieve the pagination size for the item index.
     *
     * @return int Number of items per page (default: 10)
     */
    public function getPerPage(): int
    {
        return $this->input('perPage', 10);
    }
}
