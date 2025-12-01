# Fortune Pacific 网站完整清理规范

## 清理分类

### 1. 每工作3小时清理
- 清理网站目录中的备份文件 (*.backup*)
- 清理网站目录中的before_*文件
- 清理临时文件 (_index.html, temp_*)
- 清理系统临时文件 (/root/temp_*)

### 2. 每日清理
- 清理tmp目录中7天以上的文件
- 截断大于100MB的日志文件
- 清理VS Code和灵码缓存文件
- 清理宝塔临时文件

### 3. 工作结束时清理
- 执行完整清理脚本
- 检查磁盘空间
- 记录清理日志

## 禁止清理的文件
- 网站运行必需文件
- 数据库文件
- 配置文件
- 用户上传文件 (u_file目录)
- 正在使用的日志文件

## 自动化清理计划
- 每3小时执行一次基本清理
- 每日凌晨1点执行深度清理
- 自动记录清理日志

## 清理脚本位置
- 日常清理脚本: /root/daily_cleanup.sh
- 自动计划脚本: /root/auto_cleanup_schedule.sh
- 日志文件: /root/cleanup.log, /root/auto_cleanup.log
