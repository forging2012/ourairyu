---
layout: page
layout_type: sandwich

page_category: spec

title: 超文本标记语言规范
description: HTML 与 XHTML 的词汇表与相关 API
permalink: /specs/html/
comments: true
---

## 1 介绍 {#introduction}

### 1.1 背景 {#background}

> 这段文字为非规范的。

万维网的标记语言总是采用 HTML。尽管多年来 HTML 的一般性设计以及适配使它用于描述很多其他类型的文档，但最初主要被设计成一个语义地描述科学性文档的语言。

The main area that has not been adequately addressed by HTML is a vague subject referred to as Web Applications. This specification attempts to rectify this, while at the same time updating the HTML specifications to address issues raised in the past few years.

### 1.2 受众 {#audience}

> 这段文字为非规范的。

该规范适用于使用本规范中定义的特性的文档及脚本作者、使用本规范中定义的特性去开发页面操作工具的实现者以及……（and individuals wishing to establish the correctness of documents or implementations with respect to the requirements of this specification.）

This document is probably not suited to readers who do not already have at least a passing familiarity with Web technologies, as in places it sacrifices clarity for precision, and brevity for completeness. More approachable tutorials and authoring guides can provide a gentler introduction to the topic.

In particular, familiarity with the basics of DOM is necessary for a complete understanding of some of the more technical parts of this specification. An understanding of Web IDL, HTTP, XML, Unicode, character encodings, JavaScript, and CSS will also be helpful in places but is not essential.

### 1.3 范围 {#scope}

> 这段文字为非规范的。

本规范仅限于提供语义级的标记语言和相关的语义级的脚本 API，用于创作网络范围内可访问的页面，使其能够从静态文档转化为动态应用程序。

本规范的范围不包括提供根据媒介来进行表现定制的机制（尽管网页浏览器的默认渲染规则包含在了本规范的末尾，并且挂接到 CSS 的一些机制作为语言的一部分被提供）。

The scope of this specification is not to describe an entire operating system. In particular, hardware configuration software, image manipulation tools, and applications that users would be expected to use with high-end workstations on a daily basis are out of scope. In terms of applications, this specification is targeted specifically at applications that would be expected to be used by users on an occasional basis, or regularly but from disparate locations, with low CPU requirements. Examples of such applications include online purchasing systems, searching systems, games (especially multiplayer online games), public telephone books or address books, communications software (e-mail clients, instant messaging clients, discussion software), document editing software, etc.

### 1.7 本规范的结构 {#structure-of-this-specification}

> 这段文字为非规范的。

本规范被分成以下几个主要部分：

[介绍](#introduction)
: 为 HTML 标准提供上下文的非规范资料



<!--
<header>
  <h1>HTML5</h1>
  <p>A vocabulary and associated APIs for HTML and XHTML</p>
  <h2>W3C Candidate Recommendation 04 February 2014</h2>
</header>
<p>This document is a translation of HTML Specification. (<a href="http://www.w3.org/TR/2014/CR-html5-20140204/" target="_blank">http://www.w3.org/TR/2014/CR-html5-20140204/</a>)</p>
<hr>
<h2>Abstract</h2>
<p>This specification defines the 5th major revision of the core language of the World Wide Web: the Hypertext Markup Language (HTML). In this version, new features are introduced to help Web application authors, new elements are introduced based on research into prevailing authoring practices, and special attention has been given to defining clear conformance criteria for user agents in an effort to improve interoperability.</p>
<h2>Table of Contents</h2>
<ol>
  <li>1 Introduction
    <ol>
      <li>1.1 Backgroud</li>
      <li>1.2 Audience</li>
      <li>1.3 Scope</li>
      <li>1.4 History</li>
      <li>1.5 Design notes
        <ol>
          <li>1.5.1 Serializability of script execution</li>
          <li>1.5.2 Compliance with other specifications</li>
          <li>1.5.3 Extensibility</li>
        </ol>
      </li>
      <li>1.6 HTML vs XHTML</li>
      <li>1.7 Structure of this specification
        <ol>
          <li>1.7.1 How to read this specification</li>
          <li>1.7.2 Typographic conventions</li>
        </ol>
      </li>
      <li>1.8 Privacy concerns</li>
      <li>1.9 A quick introduction to HTML
        <ol>
          <li>1.9.1 Writing secure applications with HTML</li>
          <li>1.9.2 Common pitfalls to avoid when using the scripting APIs</li>
          <li>1.9.3 How to catch mistakes when writing HTML: validators and conformance checkers</li>
        </ol>
      </li>
      <li>1.10 Conformance requirements for authors
        <ol>
          <li>1.10.1 Presentational markup</li>
          <li>1.10.2 Syntax errors</li>
          <li>1.10.3 Restrictions on content models and on attribute values</li>
        </ol>
      </li>
      <li>1.11 Suggested reading</li>
    </ol>
  </li>
  <li>2 Common infrastructure
    <ol>
      <li>2.1 Terminology
        <ol>
          <li>2.1.1 Resources</li>
          <li>2.1.2 XML</li>
          <li>2.1.3 DOM trees</li>
          <li>2.1.4 Scripting</li>
          <li>2.1.5 Plugins</li>
          <li>2.1.6 Character encodings</li>
        </ol>
      </li>
      <li>2.2 Conformance requirements
        <ol>
          <li>2.2.1 Conformance classes</li>
          <li>2.2.2 Dependencies</li>
          <li>2.2.3 Extensibility</li>
          <li>2.2.4 Interactions with XPath and XSLT</li>
        </ol>
      </li>
      <li>2.3 Case-sensitivity and string comparison</li>
      <li>2.4 Common microsyntaxes
        <ol>
          <li>2.4.1 Common parser idioms</li>
          <li>2.4.2 Boolean attributes</li>
          <li>2.4.3 Keywords and enumerated attributes</li>
          <li>2.4.4 Numbers
            <ol>
              <li>2.4.4.1 Signed integers</li>
              <li>2.4.4.2 Non-negative integers</li>
              <li>2.4.4.3 Floating-point numbers</li>
              <li>2.4.4.4 Percentages and lengths</li>
              <li>2.4.4.5 Lists of integers</li>
              <li>2.4.4.6 Lists of dimensions</li>
            </ol>
          </li>
          <li>2.4.5 Dates and times
            <ol>
              <li>2.4.5.1 Months</li>
              <li>2.4.5.2 Dates</li>
              <li>2.4.5.3 Yearless dates</li>
              <li>2.4.5.4 Times</li>
              <li>2.4.5.5 Local dates and times</li>
              <li>2.4.5.6 Time zones</li>
              <li>2.4.5.7 Global dates and times</li>
              <li>2.4.5.8 Weeks</li>
              <li>2.4.5.9 Durations</li>
              <li>2.4.5.10 Vaguer moments in time</li>
            </ol>
          </li>
          <li>2.4.6 Colors</li>
          <li>2.4.7 Space-separated tokens</li>
          <li>2.4.8 Comma-separated tokens</li>
          <li>2.4.9 References</li>
          <li>2.4.10 Media queries</li>
        </ol>
      </li>
      <li>2.5 URLs
        <ol>
          <li>2.5.1 Terminology</li>
          <li>2.5.2 Resolving URLs</li>
          <li>2.5.3 Dynamic changes to base URLs</li>
        </ol>
      </li>
      <li>2.6 Fetching resources
        <ol>
          <li>2.6.1 Terminology</li>
          <li>2.6.2 Processing model</li>
          <li>2.6.3 Encrypted HTTP and related security concerns</li>
          <li>2.6.4 Determing the type of a resource</li>
          <li>2.6.5 Extracting character encodings from <code>meta</code> elements</li>
          <li>2.6.6 CORS settings attributes</li>
          <li>2.6.7 CORS-enabled fetch</li>
        </ol>
      </li>
      <li>2.7 Common DOM interfaces
        <ol>
          <li>2.7.1 Reflecting content attributes in IDL attributes</li>
          <li>2.7.2 Collections
            <ol>
              <li>2.7.2.1 HTMLAllCollection</li>
              <li>2.7.2.2 HTMLFormControlsCollection</li>
              <li>2.7.2.3 HTMLOptionsCollection</li>
            </ol>
          </li>
          <li>2.7.3 DOMStringMap</li>
          <li>2.7.4 Transferable objects</li>
          <li>2.7.5 Safe passing of structured data</li>
          <li>2.7.6 Callbacks</li>
          <li>2.7.7 Garbage collection</li>
        </ol>
      </li>
      <li>2.8 Namespaces</li>
    </ol>
  </li>
  <li>3 Semantics, structure, and APIs of HTML documents
    <ol>
      <li>3.1 Documents
        <ol>
          <li>3.1.1 The <code>Document</code> object</li>
          <li>3.1.2 Resource metadata management</li>
          <li>3.1.3 DOM tree accessors</li>
          <li>3.1.4 Loading XML documents</li>
        </ol>
      </li>
      <li>3.2 Elements
        <ol>
          <li>3.2.1 Semantics</li>
          <li>3.2.2 Elements in the DOM</li>
          <li>3.2.3 Element definitions
            <ol>
              <li>3.2.3.1 Attributes</li>
            </ol>
          </li>
          <li>3.2.4 Content models
            <ol>
              <li>3.2.4.1 Kinds of content
                <ol>
                  <li>3.2.4.1.1 Metadata content</li>
                  <li>3.2.4.1.2 Flow content</li>
                  <li>3.2.4.1.3 Sectioning content</li>
                  <li>3.2.4.1.4 Heading content</li>
                  <li>3.2.4.1.5 Phrasing content</li>
                  <li>3.2.4.1.6 Embedded content</li>
                  <li>3.2.4.1.7 Interactive content</li>
                  <li>3.2.4.1.8 Palpable content</li>
                  <li>3.2.4.1.9 Script-supporting elements</li>
                </ol>
              </li>
              <li>3.2.4.2 Transparent content models</li>
              <li>3.2.4.3 Paragraphs</li>
            </ol>
          </li>
          <li>3.2.5 Global attributes
            <ol>
              <li>3.2.5.1 The <code>id</code> attribute</li>
              <li>3.2.5.2 The <code>title</code> attribute</li>
              <li>3.2.5.3 The <code>lang</code> and <code>xml:lang</code> attributes</li>
              <li>3.2.5.4 The <code>translate</code> attribute</li>
              <li>3.2.5.5 The <code>xml:base</code> attribute (XML only)</li>
              <li>3.2.5.6 The <code>dir</code> attribute</li>
              <li>3.2.5.7 The <code>class</code> attribute</li>
              <li>3.2.5.8 The <code>style</code> attribute</li>
              <li>3.2.5.9 Embedding custom non-visible data with the <code>data-*</code> attributes</li>
            </ol>
          </li>
          <li>3.2.6 Requirements relating to the bidirectional algorithm
            <ol>
              <li>3.2.6.1 Authoring conformance criteria for bidirectional-algorithm formatting characters</li>
              <li>3.2.6.2 User agent conformance criteria</li>
            </ol>
          </li>
          <li>3.2.7 WAI-ARIA
            <ol>
              <li>3.2.7.1 ARIA Role Attribute</li>
              <li>3.2.7.2 State and Property Attributes</li>
              <li>3.2.7.3 Strong Native Semantics</li>
              <li>3.2.7.4 Implicit ARIA Semantics</li>
              <li>3.2.7.5 Allowed ARIA roles, states and properties</li>
            </ol>
          </li>
        </ol>
      </li>
    </ol>
  </li>
  <li>4 The elements of HTML
    <ol>
      <li>4.1 The root element
        <ol>
          <li>4.1.1 The <code>html</code> element</li>
        </ol>
      </li>
      <li>4.2 Document metadata
        <ol>
          <li>4.2.1 The <code>head</code> element</li>
          <li>4.2.2 The <code>title</code> element</li>
          <li>4.2.3 The <code>base</code> element</li>
          <li>4.2.4 The <code>link</code> element</li>
          <li>4.2.5 The <code>meta</code> element
            <ol>
              <li>4.2.5.1 Standard metadata names</li>
              <li>4.2.5.2 Other metadata names</li>
              <li>4.2.5.3 Pragma directives</li>
              <li>4.2.5.4 Other pragma directives</li>
              <li>4.2.5.5 Specifying the document's character encoding</li>
            </ol>
          </li>
          <li>4.2.6 The <code>style</code> element</li>
          <li>4.2.7 Styling</li>
        </ol>
      </li>
    </ol>
  </li>
</ol>
-->