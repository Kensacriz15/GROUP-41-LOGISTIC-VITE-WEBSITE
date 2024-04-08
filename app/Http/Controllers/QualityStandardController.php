<?php
namespace App\Http\Controllers;

use App\Models\QualityStandard;

class QualityStandardController extends Controller
{
    public function index()
    {
        $qualityStandards = QualityStandard::all();

        return view('app.quality-standards.index', compact('qualityStandards'));
    }

}
