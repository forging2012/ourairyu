<?php get_header(); ?>
  <!-- 页首 -->
  <header>
    <div>
      <h1>站点标题</h1>
      <p>站点描述</p>
      <!-- 导航菜单 -->
      <nav>
        <ul>
          <li><a href="#">页面一</a></li>
          <li><a href="#">页面二</a></li>
        </ul>
      </nav>
    </div>
    <div>
      <!-- 面包屑 -->
      <nav>
        <ul>
          <li><a href="#">首页</a></li>
          <li><a href="#">上级页面</a></li>
          <li>当前页面</li>
        </ul>
      </nav>
    </div>
  </header>
  <!-- 主要区域 -->
  <main>{{ content }}</main>
  <!-- 页脚 -->
  <footer></footer>
<?php get_footer(); ?>
