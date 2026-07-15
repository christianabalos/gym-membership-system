<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function index()
    {
        if (request()->is('member/bmi')) {
            return view('member.bmi');
        }

        return view('bmi.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'age' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
        ]);

        $age = $request->age;
        $weight = $request->weight;
        $height = $request->height;

        $heightInMeters = $height / 100;
        $bmi = $weight / ($heightInMeters * $heightInMeters);

        if ($bmi < 18.5) {
            $category = 'Underweight';
        } elseif ($bmi < 25) {
            $category = 'Normal';
        } elseif ($bmi < 30) {
            $category = 'Overweight';
        } else {
            $category = 'Obese';
        }

        if (request()->is('member/bmi')) {
            return view('member.bmi', compact(
                'age',
                'weight',
                'height',
                'bmi',
                'category'
            ));
        }

        return view('bmi.index', compact(
            'age',
            'weight',
            'height',
            'bmi',
            'category'
        ));
    }
}