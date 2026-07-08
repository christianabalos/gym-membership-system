<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function index()
    {
        if (request()->routeIs('member.bmi')) {
            return view('member.bmi');
        }

        return view('bmi.index');
    }

    public function calculate(Request $request)
    {

        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
        ]);

        $age = $request->age;
        $weight = $request->weight;
        $heightInCm = $request->height;
        $heightInMeters = $heightInCm / 100;

        $bmi = $weight / ($heightInMeters * $heightInMeters);
        $bmi = round($bmi, 2);

        if ($age < 18) {
            $category = 'Child/Teen BMI';
            $message = 'For ages below 18, BMI should be interpreted using an age-based BMI chart.';
        } else {
            if ($bmi < 18.5) {
                $category = 'Underweight';
            } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
                $category = 'Normal weight';
            } elseif ($bmi >= 25 && $bmi <= 29.9) {
                $category = 'Overweight';
            } else {
                $category = 'Obese';
            }

            $message = 'BMI category is based on adult BMI classification.';
        }

        if (request()->routeIs('member.bmi.calculate')) {
        
            return view('member.bmi', compact('age', 'bmi', 'category', 'message'));
        }

        return view('bmi.index', compact('age', 'bmi', 'category', 'message'));
    }
}