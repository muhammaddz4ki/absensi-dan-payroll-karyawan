<?php namespace App\Controllers;
use App\Models\UserModel;
class ProfilController extends BaseController {
    public function index() {
        return view('karyawan/profil/index', ['title' => 'Ubah Password']);
    }
    public function updatePassword() {
        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password_baru]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);
        if (!password_verify($this->request->getPost('password_lama'), $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }
        $userModel->update($userId, ['password' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)]);
        return redirect()->to('/profil')->with('success', 'Password berhasil diperbarui.');
    }
}