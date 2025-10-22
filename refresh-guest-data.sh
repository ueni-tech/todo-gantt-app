#!/bin/bash

# すべてのダミーデータを完全にリセットするスクリプト
# このスクリプトは毎日実行され、すべてのユーザーデータを削除して再作成します
# ポートフォリオ用途専用

cd /home/uenishi/dev/portfolio

LOG_FILE="/home/uenishi/dev/portfolio/logs/guest-data-refresh.log"
LOG_DIR="/home/uenishi/dev/portfolio/logs"

mkdir -p "$LOG_DIR"

echo "========================================" >> "$LOG_FILE"
echo "開始時刻: $(date '+%Y-%m-%d %H:%M:%S')" >> "$LOG_FILE"

docker compose exec -T php bash -c "cd todo-gantt && php artisan guest:refresh" >> "$LOG_FILE" 2>&1

if [ $? -eq 0 ]; then
    echo "ステータス: 成功" >> "$LOG_FILE"
else
    echo "ステータス: 失敗" >> "$LOG_FILE"
fi

echo "終了時刻: $(date '+%Y-%m-%d %H:%M:%S')" >> "$LOG_FILE"
echo "" >> "$LOG_FILE"

find "$LOG_DIR" -name "guest-data-refresh.log" -mtime +30 -delete 2>/dev/null

