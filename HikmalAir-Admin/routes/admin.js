const express = require('express');
const bcrypt = require('bcrypt');

module.exports = (query) => {
  const router = express.Router();

  router.get('/', async (req, res) => {
    try {
      const rows = await query('SELECT id, username, nama_lengkap, email FROM admins');
      res.json(rows);
    } catch (err) {
      res.status(500).json({ error: 'Failed to fetch admins.' });
    }
  });

  router.post('/', async (req, res) => {
    const { username, password, nama_lengkap, email } = req.body;
    if (!username || !password || !nama_lengkap) {
      return res.status(400).json({ error: 'Required fields missing' });
    }
    try {
      const hash = await bcrypt.hash(password, 10);
      const result = await query(
        'INSERT INTO admins (username, password, nama_lengkap, email) VALUES (?, ?, ?, ?)',
        [username, hash, nama_lengkap, email]
      );
      res.status(201).json({ message: 'Admin created', id: result.insertId });
    } catch (err) {
      res.status(500).json({ error: 'Failed to create admin.' });
    }
  });

  router.put('/:id', async (req, res) => {
    const { id } = req.params;
    const { username, password, nama_lengkap, email } = req.body;
    try {
      let sql, params;
      if (password) {
        const hash = await bcrypt.hash(password, 10);
        sql = 'UPDATE admins SET username=?, password=?, nama_lengkap=?, email=? WHERE id=?';
        params = [username, hash, nama_lengkap, email, id];
      } else {
        sql = 'UPDATE admins SET username=?, nama_lengkap=?, email=? WHERE id=?';
        params = [username, nama_lengkap, email, id];
      }
      await query(sql, params);
      res.json({ message: 'Admin updated' });
    } catch (err) {
      res.status(500).json({ error: 'Failed to update admin.' });
    }
  });

  router.delete('/:id', async (req, res) => {
    try {
      await query('DELETE FROM admins WHERE id = ?', [req.params.id]);
      res.json({ message: 'Admin deleted' });
    } catch (err) {
      res.status(500).json({ error: 'Failed to delete admin.' });
    }
  });

  return router;
};
