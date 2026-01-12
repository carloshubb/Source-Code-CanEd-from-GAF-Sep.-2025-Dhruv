<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'backup_images' => 'array',
    ];

    public function schoolDetail()
    {
        return $this->hasMany(SchoolDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }

    public function virtualTours()
    {
        return $this->hasMany(VirtualTour::class);
    }

    public function openDays()
    {
        return $this->hasMany(openDay::class);
    }

    public function schoolScholarships()
    {
        return $this->hasMany(SchoolScholarship::class);
    }



    public function schoolContacts()
    {
        return $this->hasMany(SchoolContact::class);
    }

    public function schoolContactSetting()
    {
        return $this->hasOne(SchoolContactSetting::class);
    }
    public function schoolAmbassadorSetting()
    {
        return $this->hasOne(SchoolAmbassadorSetting::class);
    }

    public function schoolPrograms()
    {
        return $this->hasMany(SchoolProgram::class);
    }

    public function schoolProgramSetting()
    {
        return $this->hasOne(SchoolProgramSetting::class);
    }

    public function scholarshipSetting()
    {
        return $this->hasOne(ScholarshipSetting::class);
    }

    public function schoolEmployees()
    {
        return $this->hasMany(SchoolEmployee::class);
    }

    public function schoolOverview()
    {
        return $this->hasOne(SchoolOverview::class);
    }

    public function schoolFinancial()
    {
        return $this->hasOne(SchoolFinancial::class);
    }

    public function schoolQuickFact()
    {
        return $this->hasOne(SchoolQuickFact::class);
    }
    public function admissionSetting()
    {
        return $this->hasOne(AdmissionSetting::class);
    }

    public function schoolAmbassador()
    {
        return $this->hasMany(SchoolAmbassador::class)->with('school')->where('status', 'active');
    }

    public function masterApplications()
    {
        return $this->hasMany(MasterApplication::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->with('FaqDetail')->orderBy('order', 'asc');
    }

    public function schoolDemetraSetting()
    {
        return $this->hasOne(SchoolDemetraSetting::class, 'school_id', 'id');
    }

    public function schoolMoreImages()
    {
        return $this->hasMany(SchoolMoreImage::class);
    }

    public function schoolMoreLinks()
    {
        return $this->hasMany(SchoolMoreLink::class);
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class, 'record_id', 'id')->where('model', 'school');
    }

    public function getFinalImage()
    {
        $image = $this->image;
        $backupImages = $this->backup_images ?? [];

        // 1. Check primary image (remote or local)
        if ($image) {
            if (filter_var($image, FILTER_VALIDATE_URL) && checkImageUrl($image)) {
                return $image;
            }

            if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
                $localPath = public_path(thumbnailImage($image));

                if (file_exists($localPath)) {
                    return asset(thumbnailImage($image));
                }
            }
        }

        // 2. Check backup images
        if (!empty($backupImages) && is_array($backupImages)) {
            foreach ($backupImages as $backup) {
                if (filter_var($backup, FILTER_VALIDATE_URL) && checkImageUrl($backup)) {
                    return $backup;
                }
            }
        }

        // 3. Default fallback
        return asset('images/thumbnail-1751880838-789.png');
    }
}
