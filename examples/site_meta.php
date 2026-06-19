<?php

/**
 * SiteMeta - 站点元信息管理
 */

class SiteMeta
{
    private array $items = [];

    public function __construct(array $data = [])
    {
        $this->items = $data;
    }

    /**
     * 添加一条元信息
     */
    public function add(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * 获取指定键的值
     */
    public function get(string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * 生成简短描述文本（用于网页 meta description 等）
     */
    public function generateDescription(int $maxLength = 150): string
    {
        $parts = [];

        $siteName = $this->get('site_name');
        if ($siteName) {
            $parts[] = $siteName;
        }

        $keywords = $this->get('keywords');
        if (!empty($keywords)) {
            $parts[] = '关键词：' . implode('、', $keywords);
        }

        $url = $this->get('url');
        if ($url) {
            $parts[] = '官网：' . $url;
        }

        $intro = $this->get('introduction');
        if ($intro) {
            $parts[] = $intro;
        }

        $description = implode(' | ', $parts);

        if (mb_strlen($description) > $maxLength) {
            $description = mb_substr($description, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 导出完整数组
     */
    public function toArray(): array
    {
        return $this->items;
    }
}

// 示例用法
$meta = new SiteMeta([
    'site_name' => '乐鱼体育',
    'url' => 'https://m-app-leyusports.com.cn',
    'keywords' => ['乐鱼体育', '体育资讯', '赛事直播'],
    'introduction' => '提供最新体育赛事信息与专业数据分析',
    'author' => '乐鱼团队',
    'language' => 'zh-CN',
]);

$meta->add('robots', 'index, follow');

echo $meta->generateDescription(120) . PHP_EOL;