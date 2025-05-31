require('dotenv').config();
const express = require('express');
const path = require('path');
const mysql = require('mysql2/promise');

const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use('/public', express.static(path.join(__dirname, 'public')));

const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  port: process.env.DB_PORT || 3306,
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'hikmalair_admin'
};

const pool = mysql.createPool(dbConfig);
async function query(sql, params) {
  const [rows] = await pool.execute(sql, params);
  return rows;
}

(async () => {
  try {
    const conn = await pool.getConnection();
    console.log('Connected to MySQL:', dbConfig.database);
    conn.release();
  } catch (err) {
    console.error('MySQL Connection Error:', err);
    process.exit(1);
  }
})();

// Register routes
app.use('/api/admins', require('./routes/admin')(query));
app.get('/', (req, res) => res.send('HikmalAir Admin Panel API running'));

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));