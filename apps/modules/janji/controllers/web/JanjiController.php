<?php

namespace Phalcon\Init\Janji\Controllers\Web;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Request;
use Phalcon\Init\Models\Users as User;
use Phalcon\Init\Models\Janji as Janji;

class JanjiController extends Controller
{
    public function beforeExecuteRoute()
    {
        if(!$this->session->has('user_aktif')) {
            return $this->response->redirect('/login');
        }
    }

    public function showAction()
    {
        if($this->session->has('user_aktif')){
            $riwayat = null;
            $janji = User::findFirst("email = '{$this->session->get('user_aktif')['email']}'");
            $riwayat = Janji::find("id_pasien = {$janji->id_user}");
            $this->view->riwayat = $riwayat;

            $dokters = User::find('jenis_user=2');
            $this->view->dokters = $dokters;

            $this->view->pick('janji/janji');
        }
    }

    public function addJanjiAction()
    {
        $janji_add = new Janji();
        $pasien = User::findFirst("email = '{$this->session->get('user_aktif')['email']}'");
        $janji_add->id_pasien = $pasien->id_user;
        $dokter = User::findFirst("nama = '{$this->request->getPost('dokter')}'");
        $janji_add->id_dokter = $dokter->id_user;
        $janji_add->tgl = $this->request->getPost('tgl');
        $janji_add->jam = $this->request->getPost('jam');
        $janji_add->status = "Menunggu";
        $janji_add->save();
        $this->response->redirect('/janji');

    }

    public function deleteAction()
    {
        $janji = User::findFirst("email = '{$this->session->get('user_aktif')['email']}'");
        $riwayat = Janji::findFirst([
            'id_pasien = ?1 AND id_janji = ?2',
            'bind' => [
                1 => $janji->id_user,
                2 => str_replace('/','', $this->dispatcher->getParam('id')),
            ],
        ]);
        $riwayat->delete();
        $this->flashSession->success('Janji Berhasil Dihapus!');
        $this->response->redirect('/janji');
    }
    
    public function janjiDokterAction()
    {
        $riwayat = null;
        $janji_belum = User::findFirst("email = '{$this->session->get('user_aktif')['email']}'");
        $tanggal_hariini = date('Y-m-d');
        $janji_sekarang = Janji::find("id_dokter = {$janji_belum->id_user} AND status='Menunggu' AND tgl = '{$tanggal_hariini}'");
        $janji_sudah = Janji::find("id_dokter = {$janji_belum->id_user} AND NOT status='Menunggu' ");
        $this->view->janji_sekarang = $janji_sekarang;
        $this->view->janji_sudah = $janji_sudah;

        $this->view->pick('janji/janjiDokter');
    }


    public function updateAction()
    {
        $id = $this->request->getPost('nomor_id');
        $janji = Janji::findFirst($id);
        $janji->status = "Selesai";
        $janji->save();
        $this->flashSession->success('Janji Selesai Disetujui');
        $this->response->redirect('/janji/janji_dokter');
    }
}