<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Message;
use App\Models\Project; 
use App\Models\AboutPanel; 
use App\Models\Keahlian; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    // ==========================================
    // DATA DEFAULT BAWAAN (DATABASE AWAL)
    // ==========================================
    private function getDefaultData()
    {
        return [
            'name'        => 'Alfiansyah Ibdani',
            'role'        => 'IT Engineering & Web Developer_', 
            'about'       => 'Siswa kelas 12 IT Engineering dengan minat mendalam di bidang pengembangan web dan desain UI/UX.',
            'about_title' => 'Membangun Solusi Digital dengan Logika & Kreativitas',
            'about_sub_1' => '01 / TENTANG SAYA',
            'about_1'     => 'Siswa kelas 12 IT Engineering dengan minat mendalam di bidang pengembangan web dan desain UI/UX. Aktif berorganisasi sebagai Sekretaris Umum OSIS dan Ketua Karang Taruna untuk mengasah kepemimpinan, manajemen tim, dan komunikasi.',
            'about_sub_2' => '',
            'about_2'     => '',
            'about_sub_3' => '',
            'about_3'     => '',
            'email'       => 'yanzewty@gmail.com',
            'phone'       => '088235921495',
            'address'     => 'Perumahan Palempertiwi, Menganti, Gresik',
            'badge_1'     => 'Sekrum OSIS 2025-2026',
            'badge_2'     => '< /> Web Dev & UI/UX',
            'skills'      => json_encode(['HTML', 'CSS', 'PHP', 'Laravel', 'UI/UX Design', 'Poster Digital']),
            'education'   => json_encode([]),
            'experiences' => json_encode([]),
            'hobbies'     => json_encode(['Eksplorasi Teknologi', 'Gaming Conqueror'])
        ];
    }

    // ==========================================
    // HALAMAN UTAMA PUBLIK (FRONT-END)
    // ==========================================
    public function index()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        $projects = Project::latest()->get(); 
        $panels = AboutPanel::latest()->get(); 
        $dataKeahlian = Keahlian::oldest()->get(); 
        
        return view('portfolio.portofolio', compact('profile', 'projects', 'panels', 'dataKeahlian'));
    }

    
    public function dashboard()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        // PERUBAHAN: Ngitung statistik pesan yang BELUM DIBACA saja
        $totalMessages = Message::where('is_read', false)->count();
        $totalKeahlian = Keahlian::count();
        $totalProjects = Project::count();

        return view('portfolio.admin_dashboard', compact('profile', 'totalMessages', 'totalKeahlian', 'totalProjects'));
    }

    
    public function editHome()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        $skillsArray = json_decode($profile->skills, true);
        if (is_array($skillsArray)) {
            $profile->skills = implode(', ', $skillsArray);
        }
        return view('portfolio.admin_home', compact('profile'));
    }

    public function updateHome(Request $request)
    {
        $request->validate(['photo' => 'nullable|image|max:2048']);
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        $profile->name    = $request->name;
        $profile->role    = $request->role; 
        $profile->about   = $request->about; 
        $profile->email   = $request->email;
        $profile->phone   = $request->phone;
        $profile->address = $request->address; 
        $profile->badge_1 = $request->badge_1; 
        $profile->badge_2 = $request->badge_2; 

        if ($request->has('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
            $profile->skills = json_encode(array_filter($skillsArray));
        }

        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) { mkdir($uploadPath, 0755, true); }

        if ($request->hasFile('photo')) {
            if (!empty($profile->photo) && file_exists($uploadPath . '/' . $profile->photo)) {
                @unlink($uploadPath . '/' . $profile->photo);
            }
            $file = $request->file('photo');
            $filename = time() . "_photo_" . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $profile->photo = $filename;
        }

        $profile->save();
        return redirect()->back()->with('success_msg', 'Data Home berhasil diperbarui!');
    }

    // ==========================================
    // CMS 2: KELOLA ABOUT (TENTANG SAYA)
    // ==========================================
    public function editAbout()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        $panels = AboutPanel::latest()->get(); 
        return view('portfolio.admin_about', compact('profile', 'panels')); 
    }

    public function updateAbout(Request $request)
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        $profile->about_sub_1 = $request->about_sub_1;
        $profile->about_title = $request->about_title;
        $profile->about_1     = $request->about_1;
        $profile->save();
        return redirect()->back()->with('success_msg', 'Data Tentang Saya berhasil diperbarui!');
    }

    public function panelStore(Request $request)
    {
        AboutPanel::create($request->all());
        return redirect()->back()->with('success_msg', 'Section Baru Berhasil Ditambahkan!');
    }

    public function panelEdit($id)
    {
        $panel = AboutPanel::findOrFail($id);
        return view('portfolio.admin_panels_edit', compact('panel'));
    }

    public function panelUpdate(Request $request, $id)
    {
        $panel = AboutPanel::findOrFail($id);
        $panel->update($request->all());
        return redirect()->route('admin.about')->with('success_msg', 'Section berhasil diperbarui!');
    }

    public function panelDestroy($id)
    {
        AboutPanel::findOrFail($id)->delete();
        return redirect()->back()->with('success_msg', 'Section Berhasil Dihapus dari website!');
    }

    // ==========================================
    // CMS 3: KELOLA ORGANISASI (TIMELINE)
    // ==========================================
    public function orgAdmin()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        // Kita pinjam field 'education' yang nganggur untuk simpan header organisasi
        $header = json_decode($profile->education, true);
        if (!is_array($header) || !isset($header['title'])) {
            $header = [
                'tag' => '04 / PENGALAMAN ORGANISASI',
                'title' => 'Jejak Kepemimpinan',
                'desc' => 'Peran yang membentuk cara saya bekerja dalam tim dan mengambil keputusan.'
            ];
        }

        $experiencesJson = $profile->experiences ?: '[]';
        
        return view('portfolio.admin_organizations', compact('profile', 'header', 'experiencesJson'));
    }

    public function updateOrgAdmin(Request $request)
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        // Simpan Teks Header ke field education
        $header = [
            'tag' => $request->org_tag,
            'title' => $request->org_title,
            'desc' => $request->org_desc,
        ];
        $profile->education = json_encode($header);
        
        // Simpan data JSON baris organisasi
        if ($request->has('experiences_data')) {
            $profile->experiences = $request->experiences_data;
        }

        $profile->save();
        return redirect()->back()->with('success_msg', 'Header & Jejak Organisasi berhasil diperbarui!');
    }

    // ==========================================
    // CMS 4: KELOLA PESAN MASUK
    // ==========================================
    public function storeMessage(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            Message::create($request->only(['name', 'email', 'message']));
            return response()->json(['success' => 'Terima kasih! Pesan berhasil dikirim.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim pesan: ' . $e->getMessage()], 500);
        }
    }

    public function messagesAdmin()
    {
        $messages = Message::latest()->get();
        return view('portfolio.admin_messages', compact('messages')); 
    }

    public function deleteMessage($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success_msg', 'Pesan berhasil dihapus!'); 
    }

    // PERUBAHAN: Fungsi untuk menandai SATU pesan sebagai dibaca (dipanggil via Javascript)
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return response()->json(['success' => true]);
    }

    // PERUBAHAN: Fungsi untuk menandai SEMUA pesan sebagai dibaca
    public function markAllAsRead()
    {
        Message::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success_msg', 'Semua pesan telah ditandai sebagai dibaca.');
    }

    // ==========================================
    // CMS 5: KELOLA PROYEK & GALERI
    // ==========================================
    public function projectsAdmin()
    {
        $projects = Project::latest()->get();
        return view('portfolio.admin_projects', compact('projects'));
    }

    public function projectCreate()
    {
        return view('portfolio.admin_project_form');
    }

    public function projectStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048', 
            'description' => 'nullable'
        ]);

        $imageName = time() . '_' . $request->image->getClientOriginalName();
        $request->image->move(public_path('uploads'), $imageName);

        Project::create([
            'title' => $request->title,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.projects')->with('success_msg', 'Proyek baru berhasil ditambahkan!');
    }

    public function projectDestroy($id)
    {
        $project = Project::findOrFail($id);
        if(file_exists(public_path('uploads/'.$project->image))){
            @unlink(public_path('uploads/'.$project->image));
        }
        $project->delete();
        return back()->with('success_msg', 'Proyek berhasil dihapus!');
    }

    // ==========================================
    // CMS 6: KELOLA LATAR BELAKANG SKILL (Kartu Modul)
    // ==========================================
    public function keahlianAdmin()
    {
        if (Keahlian::count() == 0) {
            Keahlian::create(['modul' => 'MODULE / 01', 'judul' => 'Pemrograman Web & Laravel', 'kategori' => 'DEVELOPMENT', 'gambar' => '']);
            Keahlian::create(['modul' => 'MODULE / 02', 'judul' => 'UI/UX & Poster Digital', 'kategori' => 'DESIGN & UI', 'gambar' => '']);
            Keahlian::create(['modul' => 'MODULE / 03', 'judul' => 'Kegiatan OSIS & Karang Taruna', 'kategori' => 'LEADERSHIP', 'gambar' => '']);
        }
        $dataKeahlian = Keahlian::oldest()->get();
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData()); 
        
        return view('portfolio.admin_latar_belakang_skill', compact('dataKeahlian', 'profile'));
    }

    public function updateSkillHeader(Request $request)
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        $profile->about_sub_3 = $request->skill_tag;   
        $profile->about_sub_2 = $request->skill_title; 
        $profile->about_2     = $request->skill_desc;  
        $profile->save();

        return redirect()->back()->with('success_msg', 'Teks Judul & Deskripsi Utama berhasil diperbarui!');
    }

    public function keahlianStore(Request $request)
    {
        $request->validate(['gambar' => 'required|image|max:2048', 'judul'  => 'required']);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) { mkdir($uploadPath, 0755, true); }
            $file = $request->file('gambar');
            $filename = time() . '_keahlian_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data['gambar'] = $filename;
        }
        Keahlian::create($data);
        return redirect()->back()->with('success_msg', 'Data Keahlian Baru Berhasil Ditambahkan!');
    }

    public function keahlianEdit($id)
    {
        $item = Keahlian::findOrFail($id);
        return view('portfolio.admin_latar_belakang_skill_edit', compact('item'));
    }

    public function keahlianUpdate(Request $request, $id)
    {
        $keahlian = Keahlian::findOrFail($id);
        $request->validate(['gambar' => 'nullable|image|max:2048', 'judul'  => 'required']);
        $keahlian->modul     = $request->modul;
        $keahlian->judul     = $request->judul;
        $keahlian->deskripsi = $request->deskripsi;
        $keahlian->kategori  = $request->kategori;

        if ($request->hasFile('gambar')) {
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) { mkdir($uploadPath, 0755, true); }
            if (!empty($keahlian->gambar) && file_exists($uploadPath . '/' . $keahlian->gambar)) {
                @unlink($uploadPath . '/' . $keahlian->gambar);
            }
            $file = $request->file('gambar');
            $filename = time() . '_keahlian_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $keahlian->gambar = $filename;
        }
        $keahlian->save();
        return redirect()->route('admin.latar_belakang')->with('success_msg', 'Data Kartu Keahlian Berhasil Diperbarui!');
    }

    public function keahlianDestroy($id)
    {
        $keahlian = Keahlian::findOrFail($id);
        if(!empty($keahlian->gambar) && file_exists(public_path('uploads/'.$keahlian->gambar))){
            @unlink(public_path('uploads/'.$keahlian->gambar));
        }
        $keahlian->delete();
        return redirect()->back()->with('success_msg', 'Data Keahlian Berhasil Dihapus!');
    }

    // ==========================================
    // CMS 7: KELOLA BIDANG KEAHLIAN (KOTAK-KOTAK SKILL)
    // ==========================================
    public function bidangKeahlianAdmin()
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        $header = json_decode($profile->about_3, true) ?? [
            'tag' => '03 / KEAHLIAN',
            'title' => 'Bidang Keahlian Saya',
            'desc' => 'Memadukan kemampuan teknis IT dengan tata kelola organisasi yang rapi.'
        ];
        
        // Ambil data skill dan ubah ke format objek baru
        $skillsArray = json_decode($profile->skills, true) ?? [];
        $formattedSkills = [];
        foreach($skillsArray as $item) {
            if(is_string($item)) {
                // Format lama diubah otomatis ke format baru
                $formattedSkills[] = ['name' => str_replace(',', '', $item), 'icon' => 'fas fa-code', 'color' => '#3763e0'];
            } else {
                $formattedSkills[] = $item;
            }
        }
        $skillsJson = json_encode($formattedSkills);

        return view('portfolio.admin_bidang_keahlian', compact('profile', 'header', 'skillsJson'));
    }

    public function updateBidangKeahlian(Request $request)
    {
        $profile = Profile::firstOrCreate(['id' => 1], $this->getDefaultData());
        
        $header = [
            'tag' => $request->skill_tag,
            'title' => $request->skill_title,
            'desc' => $request->skill_desc,
        ];
        $profile->about_3 = json_encode($header);

        // Simpan data JSON langsung dari form dinamis JavaScript
        if ($request->has('skills_data')) {
            $profile->skills = $request->skills_data;
        }

        $profile->save();
        return redirect()->back()->with('success_msg', 'Data Bidang Keahlian berhasil diperbarui!');
    }
}