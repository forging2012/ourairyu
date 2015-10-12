require "date"
require "time"
require "httparty"
require "json"

desc "获取并过滤掉不需要包含的 repo 信息"
task :projects do
  dir = "./_data"
  filename = "github.json"

  unless FileTest.directory?(dir)
    system "mkdir #{dir}"
  end

  # 开始获取并写入 repo 信息
  cd dir do
    open(filename, "w") do |f|
      f.puts HTTParty.get("https://api.github.com/users/ourai/repos").to_json
    end
  end

  excludedRepos = [
    19068698,   # ourai.github.io
    28067674,   # ourairyu-themes
    19260834,   # ourairyu.github.io
    35932564,   # learning
    23340879,   # waken
    16250547,   # novel
    23698214,   # domshim
    38699113,   # double-list
    18203491,   # ninja
    39214016    # CustomComponent
  ]

  cd dir do
    repos = JSON.parse(File.read(filename))
    filtered_repos = Array.new
    starred_repos = Array.new

    repos.each do |r|
      unless r["private"] == true || r["fork"] == true || excludedRepos.include?(r["id"])
        filtered_repos.push(r)

        unless r["stargazers_count"] == 0
          starred_repos.push(r)
        end
      end
    end

    # 按照 star 人数、更新日期对 repo 进行排序
    filtered_repos.sort! do |a, b|
      if a["stargazers_count"] == b["stargazers_count"]
        DateTime.parse(a["updated_at"]).to_time.to_i <=> DateTime.parse(b["updated_at"]).to_time.to_i
      else
        a["stargazers_count"] <=> b["stargazers_count"]
      end
    end
    
    starred_repos.sort! do |a, b|
      if a["stargazers_count"] == b["stargazers_count"]
        DateTime.parse(a["updated_at"]).to_time.to_i <=> DateTime.parse(b["updated_at"]).to_time.to_i
      else
        a["stargazers_count"] <=> b["stargazers_count"]
      end
    end

    open(filename, "w") do |f|
      f.puts Hash["all" => filtered_repos.reverse, "starred" => starred_repos.reverse].to_json
    end
  end
end

desc "运行"
task :run do
  system "bundle exec jekyll serve"
end

desc "部署"
task :deploy do
  dir = "../.tmp/ourairyu"

  unless FileTest.directory?("../.tmp")
    system "mkdir ../.tmp"
  end

  unless FileTest.directory?(dir)
    system "mkdir #{dir}"

    cd dir do
      system "git init"
      system "git remote add origin https://github.com/ourai/ourai.github.io.git"
      system "git fetch"
      system "git checkout master"
    end
  else
    cd dir do
      # system "git reset --hard HEAD"
      system "git pull origin master"
    end
  end

  system "rake projects"
  system "bundle exec jekyll build -d #{dir} --config _config.yml,_build/config.yml"

  cd dir do
    current_time = Time.now.strftime("%Y年%m月%d日%H时%M分%S秒")

    system "touch .nojekyll"
    system "git add -A"
    system "git commit -m '部署于#{current_time}'"
    system "git push origin master"
  end
end