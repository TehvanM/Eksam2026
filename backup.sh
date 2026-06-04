BACKUP_DIR="/var/backups/kasutajatugi"
WEB_DIR="/var/www/kasutajatugi"
DB_HOST="10.0.16.5"
DB_USER="ktadmin"
DB_PASS="Passw0rd"
DB_NAME="kasutajatugi_db"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
ARCHIVE_NAME="backup_${TIMESTAMP}.tar.gz"
TEMP_DIR="/tmp/backup_${TIMESTAMP}"


# --- Loo varukoopiate kataloog, kui pole olemas ---
mkdir -p "${BACKUP_DIR}"


# --- Loo ajutine kataloog ---
mkdir -p "${TEMP_DIR}"


# --- Kopeeri veebifailid ajutisse kataloogi ---
echo "[$(date)] Kopeerin veebifailid..."
cp -r "${WEB_DIR}" "${TEMP_DIR}/web"


# --- Dumba andmebaas ---
echo "[$(date)] Dumban andmebaasi..."
mysqldump -h "${DB_HOST}" -u "${DB_USER}" -p"${DB_PASS}" \
    "${DB_NAME}" > "${TEMP_DIR}/andmebaas_${TIMESTAMP}.sql"


# --- Paki kokku (tar.gz, nimi sisaldab kuupäeva ja kellaaega) ---
echo "[$(date)] Pakan arhiivi: ${ARCHIVE_NAME}"
tar -czf "${BACKUP_DIR}/${ARCHIVE_NAME}" -C /tmp "backup_${TIMESTAMP}"


# --- Puhasta ajutine kataloog ---
rm -rf "${TEMP_DIR}"


# --- Kustuta varukoopiad mis on vanemad kui 7 päeva ---
echo "[$(date)] Kustutan vanad varukoopiad (>7 päeva)..."
find "${BACKUP_DIR}" -name "backup_*.tar.gz" -mtime +7 -delete


echo "[$(date)] Varukoopia valmis: ${BACKUP_DIR}/${ARCHIVE_NAME}"
