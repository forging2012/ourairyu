<?php

global $oc_project;
global $oc_siteinfo;

$oc_siteinfo['title'] = '语言';
$oc_siteinfo['desc'] = '这里主要讲的是如何以全局的眼光学习语言';
$oc_siteinfo['keywords'] = "欧雷,欧雷流,ourai,ourairyu,日本,日语,日本语,日本文化,japan,japanese,sakura,樱花";

$oc_project->html_header(); ?>
  <h1><?php echo $oc_siteinfo['title']; ?></h1>
  <p>这里主要讲的是如何以全局的眼光学习语言。</p>
  <h2>必备</h2>
  <ol>
    <li>将「<a href="/clear-your-mind/">归零法</a>」融入血液</li>
    <li>了解语言学的基本知识（语音、音位等）</li>
    <li>掌握国际音标（IPA）</li>
  </ol>
  <h2>基本</h2>
  <ul>
    <li>语言/文字历史</li>
    <li>文字单位的书写及发音</li>
    <li>罗马化（拉丁转写）</li>
  </ul>
  <h2>语法</h2>
  <ul>
    <li>句子构成</li>
    <li>语体
      <ul>
        <li>口头语</li>
        <li>书面语</li>
        <li>普通题</li>
        <li>敬体</li>
      </ul>
    </li>
    <li>变形</li>
  </ul>
  <h2>文化</h2>
<?php $oc_project->html_footer(); ?>
