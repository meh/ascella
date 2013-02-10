require 'rake'
require 'rake/clean'
require 'digest/sha1'
require 'base64'

CLEAN.include('puzza.php')

task :default => :build

task :build, :password do |t, args|
	File.open 'puzza.php', 'w' do |f|
		f.write(build(password: args[:password]))
	end
end

task :encode, :password do |t, args|
	File.open 'puzza.php', 'w' do |f|
		f.write(build(password: args[:password], encode: true))
	end
end

def strip (source)
	source.gsub(/^<\?php\n/, '').gsub(/\n?\n\?>/, '')
end

def unlicense (source)
	source.sub(%r{^/\*.*\*/\n}m, '')
end

def license (source)
	source.match(%r{^(/\*.*\*/\n)}m)[1] rescue ''
end

def encode (source)
	"eval(base64_decode('#{Base64.encode64(source).gsub(/\r?\n/, '')}'));\n"
end

def build (data = {})
	password = Digest::SHA1.hexdigest(data[:password]) if data[:password]
	result   = ''
	
	result << "<?php\n\n"
	result << license(File.read('source/ascella.php'))
	result << "\n"

	sources = ''

	if password
		sources << unlicense(strip(File.read(file).sub(/%PASSWORD%/, password)))
	end

	FileList['source/utils.php',
	         'source/parser.php',
	         'source/command.php',
	         'source/input.php',
	         'source/output.php'].each {|file|
		sources << unlicense(strip(File.read(file)))
	}

	FileList['source/commands/*.php'].each {|file|
		sources << %Q{
			class _#{rand(1_000_000_000)} extends Command
			{
				const name = '#{file.match(%r{/([^./\\]+)\.php$})[1]}';

				#{unlicense(strip(File.read(file)))}
			}
		}
	}

	sources << unlicense(strip(File.read('source/ascella.php')))

	result << (data[:encode] ? encode(sources) : sources)

	result << "\n?>\n"

	result
end
