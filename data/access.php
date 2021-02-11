function openDB() {
    $db = new SQLite3('data/budgeteer.sqlite', SQLite3_OPEN_CREATE | SQLITE_OPEN_READWRITE);
    return $db;
}
