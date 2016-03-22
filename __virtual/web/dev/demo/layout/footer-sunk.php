<?php

/*
    @Title: 页脚下沉
    @Description: 页脚（footer）永远在页面最底部
    @Privacy: public
*/

global $oc_project;
global $oc_siteinfo;
global $oc_setting;
global $oc_res;

$oc_setting['limit_ie'] = false;

$t_dirname = 'demo';
$t_pathname = $oc_project->pathname;
$t_dirdemo = $oc_project->root . substr($t_pathname, 0, (strpos($t_pathname, $t_dirname) + strlen($t_dirname))) . '/';
$t_pathnameArray = CLS_Utils::pathname();
$t_filename = array_pop($t_pathnameArray);

$oc_siteinfo['title'] = '页脚下沉';
$oc_res['css'] = array(
    $oc_project->common . 'css/base.css',
    $t_dirdemo . 'css/' . $t_filename . '.css'
);

$oc_project->html_header(); ?>
        <div id="header">header</div>
        <div id="wrapper">
            <div id="main">
                <div id="sidebar">帮主走那天，我去香港的苹果店献花，有记者采访，问对苹果最impressive的事情，我回答的其中一条是能够完美的建立人与产品之间的“情感纽带”(building emotional connection between human beings and products)。  美国的一个小女孩的iPod坏了，自己把这个iPod埋在自家花园里。我见过女孩子把iPhone掉在地上后，拿起来心疼的亲它拍它。  这就是人和产品之间的情感。  围绕产品的情感植入，我觉得包括两方面：产品内，产品外。  产品外的情感主要在营销，这里面苹果的Think Different, 1984都是佳作，不一定都是煽情，也有轻松诙谐篇，苹果的PC vs. Mac就是一篇篇值得回味的让人会心一笑的作品。  产品内的情感离我最近，让我最感动的是微信上个版本启动时Michael Jackson的图片：你说我是错的，那你最好证明你是对的。  至于选择这幅图背后的故事，我不知道，但我觉得一定不是临时急就篇，大家聚在一起说“来，我们头脑风暴一下，搞个图片上流一把”(oh boy, people are doing this every day huh?)  我只觉得：“微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。”  好的情感植入和输出，本来就是主观的，个人的。如果一个产品的第一负责人自己有鲜明的个性和思想，这事儿会比较靠谱。否则，我宁愿看到一个不“情感”但是特性上有亮点，方便好用的产品。因为，生硬的模仿的情感，很别扭。用的滥，很cheap；用的偏，很山寨。用Ricky的话：有的感觉很受用，有的却如同怪味豆。  昨天和Ricky聊完，写了两条微博： 1. “和Ricky 聊产品，我说情感营销一定要谨慎，因为这个本来是很难拿捏，严重依赖把关人的。滥学情感营销只会生硬。让我想起「围城」里说的 ＂生平最恨小城市的摩登姑娘，落伍的时髦，乡气的都市化，活像那第一套中国裁缝仿制的西装，把做样子的外国人旧衣服上的补丁，也照旧在衣袖和裤子上做了。” ”  2. "有句话说：「第一个用玫瑰比喻女孩的是天才，第二个是庸才，第三个是蠢才。」微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。产品情感不是见到花花草草就眼泪汪汪 "  你要做产品的情感植入和输出，不是靠一堆码字和公关的人头脑风暴，是：首先你问自己，你对这个产品真的有情感吗？  微软看到苹果iPod成功就攒了个团队做Zune，结果做了几坨垃圾。每次我看到Zune,我只能这么形容：When I look at this, it sends a shiver up my spine....  原因是什么？  乔布斯： “Whenever we have a music event, we think it's important to remind ourselves why we do this in the first place. The reason we do this is like you, we love music.”帮主走那天，我去香港的苹果店献花，有记者采访，问对苹果最impressive的事情，我回答的其中一条是能够完美的建立人与产品之间的“情感纽带”(building emotional connection between human beings and products)。  美国的一个小女孩的iPod坏了，自己把这个iPod埋在自家花园里。我见过女孩子把iPhone掉在地上后，拿起来心疼的亲它拍它。  这就是人和产品之间的情感。  围绕产品的情感植入，我觉得包括两方面：产品内，产品外。  产品外的情感主要在营销，这里面苹果的Think Different, 1984都是佳作，不一定都是煽情，也有轻松诙谐篇，苹果的PC vs. Mac就是一篇篇值得回味的让人会心一笑的作品。  产品内的情感离我最近，让我最感动的是微信上个版本启动时Michael Jackson的图片：你说我是错的，那你最好证明你是对的。  至于选择这幅图背后的故事，我不知道，但我觉得一定不是临时急就篇，大家聚在一起说“来，我们头脑风暴一下，搞个图片上流一把”(oh boy, people are doing this every day huh?)  我只觉得：“微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。”  好的情感植入和输出，本来就是主观的，个人的。如果一个产品的第一负责人自己有鲜明的个性和思想，这事儿会比较靠谱。否则，我宁愿看到一个不“情感”但是特性上有亮点，方便好用的产品。因为，生硬的模仿的情感，很别扭。用的滥，很cheap；用的偏，很山寨。用Ricky的话：有的感觉很受用，有的却如同怪味豆。  昨天和Ricky聊完，写了两条微博： 1. “和Ricky 聊产品，我说情感营销一定要谨慎，因为这个本来是很难拿捏，严重依赖把关人的。滥学情感营销只会生硬。让我想起「围城」里说的 ＂生平最恨小城市的摩登姑娘，落伍的时髦，乡气的都市化，活像那第一套中国裁缝仿制的西装，把做样子的外国人旧衣服上的补丁，也照旧在衣袖和裤子上做了。” ”  2. "有句话说：「第一个用玫瑰比喻女孩的是天才，第二个是庸才，第三个是蠢才。」微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。产品情感不是见到花花草草就眼泪汪汪 "  你要做产品的情感植入和输出，不是靠一堆码字和公关的人头脑风暴，是：首先你问自己，你对这个产品真的有情感吗？  微软看到苹果iPod成功就攒了个团队做Zune，结果做了几坨垃圾。每次我看到Zune,我只能这么形容：When I look at this, it sends a shiver up my spine....  原因是什么？  乔布斯： “Whenever we have a music event, we think it's important to remind ourselves why we do this in the first place. The reason we do this is like you, we love music.”</div>
                <div id="content">帮主走那天，我去香港的苹果店献花，有记者采访，问对苹果最impressive的事情，我回答的其中一条是能够完美的建立人与产品之间的“情感纽带”(building emotional connection between human beings and products)。  美国的一个小女孩的iPod坏了，自己把这个iPod埋在自家花园里。我见过女孩子把iPhone掉在地上后，拿起来心疼的亲它拍它。  这就是人和产品之间的情感。  围绕产品的情感植入，我觉得包括两方面：产品内，产品外。  产品外的情感主要在营销，这里面苹果的Think Different, 1984都是佳作，不一定都是煽情，也有轻松诙谐篇，苹果的PC vs. Mac就是一篇篇值得回味的让人会心一笑的作品。  产品内的情感离我最近，让我最感动的是微信上个版本启动时Michael Jackson的图片：你说我是错的，那你最好证明你是对的。  至于选择这幅图背后的故事，我不知道，但我觉得一定不是临时急就篇，大家聚在一起说“来，我们头脑风暴一下，搞个图片上流一把”(oh boy, people are doing this every day huh?)  我只觉得：“微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。”  好的情感植入和输出，本来就是主观的，个人的。如果一个产品的第一负责人自己有鲜明的个性和思想，这事儿会比较靠谱。否则，我宁愿看到一个不“情感”但是特性上有亮点，方便好用的产品。因为，生硬的模仿的情感，很别扭。用的滥，很cheap；用的偏，很山寨。用Ricky的话：有的感觉很受用，有的却如同怪味豆。  昨天和Ricky聊完，写了两条微博： 1. “和Ricky 聊产品，我说情感营销一定要谨慎，因为这个本来是很难拿捏，严重依赖把关人的。滥学情感营销只会生硬。让我想起「围城」里说的 ＂生平最恨小城市的摩登姑娘，落伍的时髦，乡气的都市化，活像那第一套中国裁缝仿制的西装，把做样子的外国人旧衣服上的补丁，也照旧在衣袖和裤子上做了。” ”  2. "有句话说：「第一个用玫瑰比喻女孩的是天才，第二个是庸才，第三个是蠢才。」微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。产品情感不是见到花花草草就眼泪汪汪 "  你要做产品的情感植入和输出，不是靠一堆码字和公关的人头脑风暴，是：首先你问自己，你对这个产品真的有情感吗？  微软看到苹果iPod成功就攒了个团队做Zune，结果做了几坨垃圾。每次我看到Zune,我只能这么形容：When I look at this, it sends a shiver up my spine....  原因是什么？  乔布斯： “Whenever we have a music event, we think it's important to remind ourselves why we do this in the first place. The reason we do this is like you, we love music.”帮主走那天，我去香港的苹果店献花，有记者采访，问对苹果最impressive的事情，我回答的其中一条是能够完美的建立人与产品之间的“情感纽带”(building emotional connection between human beings and products)。  美国的一个小女孩的iPod坏了，自己把这个iPod埋在自家花园里。我见过女孩子把iPhone掉在地上后，拿起来心疼的亲它拍它。  这就是人和产品之间的情感。  围绕产品的情感植入，我觉得包括两方面：产品内，产品外。  产品外的情感主要在营销，这里面苹果的Think Different, 1984都是佳作，不一定都是煽情，也有轻松诙谐篇，苹果的PC vs. Mac就是一篇篇值得回味的让人会心一笑的作品。  产品内的情感离我最近，让我最感动的是微信上个版本启动时Michael Jackson的图片：你说我是错的，那你最好证明你是对的。  至于选择这幅图背后的故事，我不知道，但我觉得一定不是临时急就篇，大家聚在一起说“来，我们头脑风暴一下，搞个图片上流一把”(oh boy, people are doing this every day huh?)  我只觉得：“微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。”  好的情感植入和输出，本来就是主观的，个人的。如果一个产品的第一负责人自己有鲜明的个性和思想，这事儿会比较靠谱。否则，我宁愿看到一个不“情感”但是特性上有亮点，方便好用的产品。因为，生硬的模仿的情感，很别扭。用的滥，很cheap；用的偏，很山寨。用Ricky的话：有的感觉很受用，有的却如同怪味豆。  昨天和Ricky聊完，写了两条微博： 1. “和Ricky 聊产品，我说情感营销一定要谨慎，因为这个本来是很难拿捏，严重依赖把关人的。滥学情感营销只会生硬。让我想起「围城」里说的 ＂生平最恨小城市的摩登姑娘，落伍的时髦，乡气的都市化，活像那第一套中国裁缝仿制的西装，把做样子的外国人旧衣服上的补丁，也照旧在衣袖和裤子上做了。” ”  2. "有句话说：「第一个用玫瑰比喻女孩的是天才，第二个是庸才，第三个是蠢才。」微信的MJ闪屏是长期团队气质和某种情绪积累的自然流露。产品情感不是见到花花草草就眼泪汪汪 "  你要做产品的情感植入和输出，不是靠一堆码字和公关的人头脑风暴，是：首先你问自己，你对这个产品真的有情感吗？  微软看到苹果iPod成功就攒了个团队做Zune，结果做了几坨垃圾。每次我看到Zune,我只能这么形容：When I look at this, it sends a shiver up my spine....  原因是什么？  乔布斯： “Whenever we have a music event, we think it's important to remind ourselves why we do this in the first place. The reason we do this is like you, we love music.”</div>
            </div>
        </div>
        <div id="footer">footer</div>
<?php

$oc_project->html_footer();

?>