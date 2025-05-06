<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AvatarHelper
{
    public static function getAvatarUrl($avatarPath, $defaultAvatar = 'build/images/users/default-avatar.png')
    {
        if (!$avatarPath) {
            return asset($defaultAvatar);
        }
        
        // Check if the avatar exists in storage
        if (Storage::disk('public')->exists($avatarPath)) {
            return Storage::url($avatarPath);
        }
        
        // Fallback to default avatar
        return asset($defaultAvatar);
    }
}