<?php

namespace App\Services;

use App\Models\Bargain;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BargainService
{
    public function save(array $data, $bargain = null)
    {
        $bargain = $bargain ?? new Bargain();

        // Restrict updates if status is 'one-time' and user already updated once
        if ($bargain->exists && $bargain->status === 'one-time' && $bargain->edit_frequent >= 1) {
            throw ValidationException::withMessages([
                'edit_error' => 'You cannot update again until you paid for this.'
            ]);
        }

        // Handle profile image
        if (!empty($data['profile_image'])) {
            if ($bargain->profile_image) {
                Storage::disk('public')->delete($bargain->profile_image);
            }
            $bargain->profile_image = $data['profile_image']->store('bargains', 'public');
        }

        // Contract dates
        $bargain->contract_start_date = !empty($data['contract_start_date']) ? Carbon::parse($data['contract_start_date']) : null;
        $bargain->contract_end_date = !empty($data['contract_end_date']) ? Carbon::parse($data['contract_end_date']) : null;

        // Fill all fields including name (for update and create)
        $bargain->fill([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'website' => $data['website'] ?? null,
            'phone' => $data['phone'] ?? null,
            'whatsapp' => $data['whatsapp'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'] ?? $bargain->status ?? 'one-time',
        ]);

        // Generate registration number if new
        if (!$bargain->exists) {
            $bargain->registration_number = $this->generateRegistrationNumber();
            $bargain->edit_frequent = 0; // default for new
        } else {
            // Increment edit_frequent on update
            $bargain->edit_frequent += 1;
        }

        $bargain->save();

        return $bargain;
    }

    public function generateRegistrationNumber(): string
    {
        $lastId = Bargain::max('id') ?? 0;
        return 'TM-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }

    public function toggleStatus(Bargain $bargain)
    {
        $bargain->status = $bargain->status === 'one-time' ? 'more-time' : 'one-time';
        $bargain->save();
    }
}
