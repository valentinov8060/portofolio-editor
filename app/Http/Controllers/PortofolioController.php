<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Portofolio;
use App\Http\Controllers\Skills;
use App\Http\Controllers\Projects;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
use Exception;

class PortofolioController extends Controller
{
    public function showPortofolio()
    {
        $data = Portofolio::find(1);
    
        // Cek apakah profile_picture ada
        if (!empty($data->profile_picture)) {
            // Jika $data->profile_picture adalah resource
            if (is_resource($data->profile_picture)) {
                $data->profile_picture = stream_get_contents($data->profile_picture);
            } 
            // Ubah dari hex ke biner
            $data->profile_picture = hex2bin($data->profile_picture);
            // Encode data biner ke Base64
            $data->profile_picture = base64_encode($data->profile_picture);
        }
    
        // Cek apakah skills ada
        if (!empty($data->skills)) {
            $data->skills = json_decode($data->skills);
        }

        // Cek apakah projects ada
        if (!empty($data->projects)) {
            $data->projects = json_decode($data->projects);
        }
    
        return view('portofolio', compact('data'));
    }

    /* auth function */
    public function showLogin()
    {
        // Jika user sudah login, redirect ke halaman editor
        if (Auth::check()) {
            return redirect()->route('editor page')->with('success', 'You are already logged in.');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah ada pengguna dengan name yang diberikan
        $user = User::where('name', $request->name)->first();

        // Jika pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Set session dan redirect ke halaman editor
            Auth::login($user);
            return redirect()->route('editor page')->with('success', 'Login success!');
        }

        // Jika login gagal
        return back()->withErrors([
            'name' => 'name atau password is invalid.',
        ]);
    }

    public function showEditor()
    {
        $data = Portofolio::find(1);
    
        // Cek apakah profile_picture ada
        if (!empty($data->profile_picture)) {
            // Jika $data->profile_picture adalah resource
            if (is_resource($data->profile_picture)) {
                $data->profile_picture = stream_get_contents($data->profile_picture);
            } 
            // Ubah dari hex ke biner
            $data->profile_picture = hex2bin($data->profile_picture);
            // Encode data biner ke Base64
            $data->profile_picture = base64_encode($data->profile_picture);
        }
    
        // Cek apakah skills ada
        if (!empty($data->skills)) {
            $data->skills = json_decode($data->skills);
        }
    
        return view('editor', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login page');
    }

    /* editor function */
    public function profile(Request $request)
    {
        $validation = $request->validate([
            'name' => 'nullable|string|max:100',
            'profession' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();
            $profile = Portofolio::where('id', 1)->first();

            $data = [
                'name' => $validation['name'],
                'profession' => $validation['profession'],
                'updated_at' => now(),
            ];

            // Cek jika ada file gambar yang diupload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $imageBinary = file_get_contents($file->getRealPath());
                $imageBinary = bin2hex($imageBinary); 

                // Ambil mimeType dari file yang diupload
                $mimeType = $file->getClientMimeType();

                // Simpan data gambar dan mimeType ke database
                $data['profile_picture'] = $imageBinary;
                $data['mime_type'] = $mimeType;
            }

            $profile->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update profile: '.$e->getMessage());
            dd($e);
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function about(Request $request) {
        $validation = $request->validate([
            'about' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $profile = Portofolio::where('id', 1)->first();

            $data = [
                'about' => $validation['about'],
                'updated_at' => now(),
            ];

            $profile->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'About updated successfully.');
        } catch (Exception $e) {
            Log::error('Failed to update about: '.$e->getMessage());
            dd($e);
            return redirect()->back()->with('error', 'Failed to update about: ' . $e->getMessage());
        }
    }

    public function skills(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'desc'  => 'required|string|max:255',
        ]);
    
        try {
            DB::beginTransaction();
            // Ambil data dari form
            $skill = new Skills();
            $skill->title = $request->title;
            $skill->desc = $request->desc;
        
            // Ambil data dari database
            $portfolio = Portofolio::find(1);
        
            // Cek apakah kolom 'skills' sudah berisi data atau belum, jika belum, inisialisasi sebagai array kosong
            $existingSkills = json_decode($portfolio->skills) ?? [];
        
            // Tambahkan skill baru ke array yang sudah ada
            $existingSkills[] = $skill;
        
            // Simpan kembali ke kolom JSON
            $portfolio->skills = $existingSkills;
            $portfolio->save();
        
            DB::commit();
            return redirect()->back()->with('success', 'Skill added successfully.');
        } catch (Exception $e) {
            Log::error('Failed to add skill: '.$e->getMessage());
            dd($e);
            return redirect()->back()->with('error', 'Failed to add skill: ' . $e->getMessage());
        }
    }

    public function deleteSkill($index)
    {
        try {
            DB::beginTransaction();
            $portfolio = Portofolio::find(1);
            $existingSkills = json_decode($portfolio->skills);
            if (count($existingSkills)-1 == 0) {
                $existingSkills = [];
            } else {
                array_splice($existingSkills, $index, 1);
            }
            $portfolio->skills = $existingSkills;
            $portfolio->save();
            DB::commit();
            return redirect()->back()->with('success', 'Skill deleted successfully.');
        } catch (Exception $e) {
            Log::error('Failed to delete skill: '.$e->getMessage());
            dd($e);
            return redirect()->back()->with('error', 'Failed to delete skill: ' . $e->getMessage());
        }
    }

    public function projects(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'link' => 'required|url',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Siapkan data project
            $project = new Projects();
            $project->title = $request->title;
            $project->desc = $request->desc;
            $project->link = $request->link;
    
            // Ambil data existing dari database
            $portfolio = Portofolio::find(1);
            $existingProjects = json_decode($portfolio->projects, true) ?? [];
    
            // Simpan ke database
            $existingProjects[] = $project;
            $portfolio->projects = $existingProjects;
            $portfolio->save();
    
            DB::commit();
            return redirect()->back()->with('success', 'Project added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to store project: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add project: ' . $e->getMessage());
        }
    }
}
