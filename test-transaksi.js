import http from 'k6/http';
import { sleep, check } from 'k6';

export let options = {
    vus: 50,
    duration: '30s',
};

const BASE_URL = 'http://localhost:8000';
const TOKEN = '24|7BbO9cnurbJRWr8vPPxJP9k3ZZZX92SkueYWrWnS96a774a4';
const BARANG_ID = 3;

export function setup() {
    const params = { headers: { Authorization: 'Bearer ' + TOKEN } };
    let resBarang = http.get(`${BASE_URL}/api/barangs/${BARANG_ID}`, params);
    if (resBarang.status === 200) {
        const barangData = resBarang.json();
        console.log('Stok Awal:', barangData.stok);
        return barangData.stok;
    } else {
        console.error('Gagal ambil barang. Status:', resBarang.status);
        return 0;
    }
}

export default function () {
    const tipe = Math.random() < 0.5 ? 'masuk' : 'keluar';
    const payload = JSON.stringify({
        id_barang: BARANG_ID,
        tanggal: new Date().toISOString().split('T')[0],
        tipe_transaksi: tipe,
    });

    const params = {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + TOKEN,
        },
    };

    let res = http.post(`${BASE_URL}/api/transaksi`, payload, params);
    check(res, { 'transaksi status 200/201': (r) => r.status === 200 || r.status === 201 });

    let resBarang = http.get(`${BASE_URL}/api/barangs/${BARANG_ID}`, params);
    if (resBarang.status === 200) {
        const barangData = resBarang.json();
        if (barangData.stok < 0) {
            console.error(`❌ Deteksi Race Condition: Stok negatif = ${barangData.stok}`);
        }
    }

    sleep(0.1);
}

export function teardown() {
    console.log('Tes selesai');
}
