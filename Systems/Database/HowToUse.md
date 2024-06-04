Tentu! Berikut adalah contoh penggunaan dari setiap metode di kelas `Database` yang telah Anda buat:

```php
<?php

use Phreme\Systems\Database\Database;

try {
    // Membuat instance dari kelas Database
    $db = new Database();

    // Contoh penggunaan metode select()
    $db->select('id, name')->from('users')->get();
    $results = $db->fetchAll();
    print_r($results);

    // Contoh penggunaan metode where()
    $db->select('id, name')->from('users')->where(['id' => 1])->get();
    $user = $db->fetchRow();
    print_r($user);

    // Contoh penggunaan metode whereIn()
    $db->select('id, name')->from('users')->whereIn('id', [1, 2, 3])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Contoh penggunaan metode whereNot()
    $db->select('id, name')->from('users')->whereNot(['id' => 1])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Contoh penggunaan metode orderBy()
    $db->select('id, name')->from('users')->orderBy(['name' => 'ASC'])->get();
    $users = $db->fetchAll();
    print_r($users);

    // Contoh penggunaan metode limit()
    $db->select('id, name')->from('users')->limit(5)->get();
    $users = $db->fetchAll();
    print_r($users);

    // Contoh penggunaan metode join()
    $db->select('users.id, users.name, profiles.bio')
        ->from('users')
        ->join('profiles', 'users.id = profiles.user_id')
        ->get();
    $users = $db->fetchAll();
    print_r($users);

    // Contoh penggunaan metode insert()
    $db->insert('users', ['name' => 'John Doe', 'email' => 'john@example.com']);
    echo "User inserted with ID: " . $db->DBmysqli->insert_id;

    // Contoh penggunaan metode insertMultiple()
    $data = [
        ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
        ['name' => 'Mike Smith', 'email' => 'mike@example.com']
    ];
    $db->insertMultiple('users', $data);
    echo "Multiple users inserted.";

    // Contoh penggunaan metode update()
    $db->update('users', ['email' => 'john.new@example.com'], ['id' => 1]);
    echo "User updated.";

    // Contoh penggunaan metode delete()
    $db->delete('users', ['id' => 2]);
    echo "User deleted.";

    // Contoh penggunaan transaksi (begin, commit, rollback)
    $db->begin();
    try {
        $db->insert('users', ['name' => 'Transactional User', 'email' => 'trans@example.com']);
        $db->commit();
        echo "Transaction committed.";
    } catch (Exception $e) {
        $db->rollback();
        echo "Transaction rolled back.";
    }

    // Contoh penggunaan metode rawQuery()
    $db->rawQuery('SELECT COUNT(*) as user_count FROM users');
    $count = $db->fetchAssoc();
    print_r($count);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

**Penjelasan:**
1. **Membuat Instance Database**: Membuat objek `Database`.
2. **select()**: Memilih kolom dari tabel.
3. **where()**: Menambahkan kondisi WHERE.
4. **whereIn()**: Menambahkan kondisi WHERE IN.
5. **whereNot()**: Menambahkan kondisi WHERE NOT.
6. **orderBy()**: Menambahkan kondisi ORDER BY.
7. **limit()**: Menambahkan batasan jumlah hasil.
8. **join()**: Melakukan join dengan tabel lain.
9. **insert()**: Menyisipkan data baru ke tabel.
10. **insertMultiple()**: Menyisipkan beberapa baris data ke tabel.
11. **update()**: Memperbarui data pada tabel.
12. **delete()**: Menghapus data dari tabel.
13. **Transaksi (begin, commit, rollback)**: Mengelola transaksi database.
14. **rawQuery()**: Menjalankan kueri SQL mentah.

Setiap contoh mencakup pemanggilan metode yang relevan dari kelas `Database` dan menangani hasilnya. Ini menunjukkan bagaimana kelas tersebut dapat digunakan untuk berbagai operasi database.