app.delete('/karyawan/:id', async (req, res) => {
//     try {
//         const { id } = req.params;
//         console.log('ID diterima untuk dihapus:', id); // Debug log

//         // Validasi ID MongoDB
//         if (!ObjectId.isValid(id)) {
//             return res.status(400).json({ error: 'ID tidak valid' });
//         }

//         // Hapus berdasarkan `_id` MongoDB
//         const result = await db.collection('karyawan').deleteOne({ _id: new ObjectId(id) });

//         console.log('Hasil delete:', result); // Debug log hasil operasi delete

//         if (result.deletedCount > 0) {
//             res.json({ message: `Karyawan dengan ID ${id} berhasil dihapus!` });
//         } else {
//             res.status(404).json({ message: `Karyawan dengan ID ${id} tidak ditemukan` });
//         }
//     } catch (err) {
//         console.error('Error saat menghapus:', err); // Debug log untuk error
//         res.status(500).json({ error: 'Terjadi kesalahan saat menghapus data.' });
//     }
// });