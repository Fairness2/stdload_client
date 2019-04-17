from pulp import *
import time
import json

# print('distribution')
f = open('data.txt')
args = f.read()
# print(args)
args_json = json.loads(args)
# print(args_json)
c = args_json['F']
# print(c)
A = args_json['A']
# print(A)
b = args_json['b']
# print(b)
Aeq = args_json['Aeq']
# print(Aeq)
beq = args_json['beq']
# print(beq)
num_x = len(c)

prob = LpProblem("St Load", LpMinimize)
x = LpVariable.dicts('x', range(num_x), 0, 1, cat='Integer')

prob += lpSum([c[i] * x[i] for i in range(num_x)])

for i in range(len(b)):
    prob += lpSum([A[i][j] * x[j] for j in range(num_x)]) <= b[i]

for i in range(len(beq)):
    prob += lpSum([Aeq[i][j] * x[j] for j in range(num_x)]) == beq[i]

# print(prob)
start_time = time.time()
status = prob.solve()
# print("--- %s seconds ---" % (time.time() - start_time))
# print(LpStatus[status])
# print(value(prob.objective))

res = []
for i in range(num_x):
    res.append(value(x[i]))
    # print("x_" + str(i) + ' = ' + str(value(x[i])))

print(json.dumps(res))
