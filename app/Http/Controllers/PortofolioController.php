<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Portofolio;
use App\Models\DTO\Skills;
use App\Models\DTO\Projects;
use App\Models\DTO\Contacts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class PortofolioController extends Controller
{
    protected $userId;
    protected $validationValue;

    public function __construct()
    {
        $this->userId = env('USER_ID');

        $this->validationValue = array(
            'requiredString255' => 'required|string|max:255',
        );
    }

    public function showPortofolio()
    {
        // Ambil data portofolio berdasarkan user_id
        $data = Portofolio::where('user_id', $this->userId)->first();

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

        // Cek apakah contacts ada
        if (!empty($data->contacts)) {
            $data->contacts = json_decode($data->contacts);
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
            'name' => $this->validationValue['requiredString'],
            'password' => $this->validationValue['requiredString'],
        ]);

        // Cek apakah ada pengguna dengan name yang diberikan
        $user = User::where('name', $request->name)->first();

        // Jika pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password) && $user->id == $this->userId) {
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
        $data = Portofolio::where('user_id', $this->userId)->first();

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

        if (!empty($data->contacts)) {
            $data->contacts = json_decode($data->contacts);
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
            $portofolio = Portofolio::where('user_id', $this->userId)->first();

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

            $portofolio->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function about(Request $request) {
        $validation = $request->validate([
            'about' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $portofolio = Portofolio::where('user_id', $this->userId)->first();

            $data = [
                'about' => $validation['about'],
                'updated_at' => now(),
            ];

            $portofolio->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'About updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update about: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update about: ' . $e->getMessage());
        }
    }

    public function skills(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => $this->validationValue['requiredString255'],
            'desc'  => $this->validationValue['requiredString255'],
        ]);

        try {
            DB::beginTransaction();
            // Ambil data dari form
            $skill = new Skills();
            $skill->title = $request->title;
            $skill->desc = $request->desc;

            // Ambil data dari database
            $portofolio = Portofolio::where('user_id', $this->userId)->first();

            // Cek apakah kolom 'skills' sudah berisi data atau belum, jika belum, inisialisasi sebagai array kosong
            $existingSkills = json_decode($portofolio->skills) ?? [];

            // Tambahkan skill baru ke array yang sudah ada
            $existingSkills[] = $skill;

            // Simpan kembali ke kolom JSON
            $portofolio->skills = $existingSkills;
            $portofolio->save();

            DB::commit();
            return redirect()->back()->with('success', 'Skill added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to add skill: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to add skill: ' . $e->getMessage());
        }
    }

    public function deleteSkill($index)
    {
        try {
            DB::beginTransaction();
            $portofolio = Portofolio::where('user_id', $this->userId)->first();
            $existingSkills = json_decode($portofolio->skills);
            if (count($existingSkills)-1 == 0) {
                $existingSkills = [];
            } else {
                array_splice($existingSkills, $index, 1);
            }
            $portofolio->skills = $existingSkills;
            $portofolio->save();
            DB::commit();
            return redirect()->back()->with('success', 'Skill deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete skill: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete skill: ' . $e->getMessage());
        }
    }

    public function projects(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => $this->validationValue['requiredString255'],
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
            $portofolio = Portofolio::where('user_id', $this->userId)->first();
            $existingProjects = json_decode($portofolio->projects, true) ?? [];

            // Simpan ke database
            $existingProjects[] = $project;
            $portofolio->projects = $existingProjects;
            $portofolio->save();

            DB::commit();
            return redirect()->back()->with('success', 'Project added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to store project: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add project: ' . $e->getMessage());
        }
    }

    public function deleteProject($index)
    {
        try {
            DB::beginTransaction();
            $portofolio = Portofolio::where('user_id', $this->userId)->first();
            $existingProjects = json_decode($portofolio->projects);
            if (count($existingProjects)-1 == 0) {
                $existingProjects = [];
            } else {
                array_splice($existingProjects, $index, 1);
            }
            $portofolio->projects = $existingProjects;
            $portofolio->save();
            DB::commit();
            return redirect()->back()->with('success', 'Project deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete project: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    public function contacts(Request $request)
    {
        $request->validate([
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'email' => 'nullable|email',
        ]);

        try {
            DB::beginTransaction();
            $portofolio = Portofolio::where('user_id', $this->userId)->first();

            $contact = new Contacts();
            $contact->instagram = $request->instagram;
            $contact->linkedin = $request->linkedin;
            $contact->email = $request->email;

            $portofolio->contacts = json_encode($contact);

            $portofolio->save();
            DB::commit();
            return redirect()->back()->with('success', 'Contact updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update contact: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to update contact: ' . $e->getMessage());
        }
    }
}
