import os

data = os.popen("netstat -n").read()
data = data.splitlines()

start, end = 0, 0
for i in range(len(data[1])):
	if data[1][i] == 'F':
		start = i
	if data[1][i] == 'S':
		end = i
ips = []
for text in data[2:]:
	if 'Active' in text: break
	val = text[start:end]
	if val.split(':')[0] not in ips and val[0:2] != '::' and 'localhost' not in val and '127.0.0.1' not in val and text[end] == 'E':
		ips.append(val.split(':')[0])

p = '\n'.join(map(str,ips))
print(p)
print("-----")
print("Connected IPs: ", len(ips))
