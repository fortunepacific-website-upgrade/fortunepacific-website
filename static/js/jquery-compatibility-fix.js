/**
 * jQuery版本兼容性修复补丁
 * 确保不同版本jQuery共存时的兼容性
 */

// 检查并添加.size()方法兼容性
if (typeof jQuery !== "undefined") {
    // 为jQuery添加.size()方法（如果不存在）
    if (!jQuery.fn.size) {
        jQuery.fn.size = function() {
            return this.length;
        };
    }
    
    // 确保jQuery Migrate正常工作
    if (typeof jQuery.migrateMute === "undefined") {
        jQuery.migrateMute = true;
    }
}

// 输出兼容性补丁加载信息
console.log("jQuery 3.7.1 最终兼容性补丁已加载 - 所有.size()问题已修复");
