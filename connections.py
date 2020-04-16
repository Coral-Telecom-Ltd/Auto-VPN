import os

data = os.popen("netstat -n").read()
data = data.splitlines()

start, end = 0, 0
for i in range(len(data[3])):
	if data[3][i] == 'F':
		start = i
	if data[3][i] == 'S':
		end = i

ips = []
for text in data[4:]:
	if 'Active' in text: break
	val = text[start:end]
	if 'localhost' not in val and '127.0.0.1' not in val:
		ips.append(val)

p = '\n'.join(map(str,ips))
print(p)
print("-----")
print("Connected IPs: ", len(ips))