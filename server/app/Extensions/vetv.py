from pulp import *
import time
import json

args = sys.argv[1]
print(args)
args_json = json.load(args)
c = args_json['F']
A = args_json['A']
b = args_json['b']
Aeq = args_json['Aeq']
beq = args_json['beq']

prob = LpProblem("St Load", LpMinimize)
x = LpVariable.dicts('x', range(297), 0, 1, cat='Integer')

prob += lpSum([c[i] * x[i] for i in range(297)])

for i in range(len(b)):
    prob += lpSum([A[i][j] * x[j] for j in range(297)]) <= b[i]

for i in range(len(beq)):
    prob += lpSum([Aeq[i][j] * x[j] for j in range(297)]) == beq[i]

print(prob)
start_time = time.time()
status = prob.solve()
print("--- %s seconds ---" % (time.time() - start_time))
print(LpStatus[status])
print(value(prob.objective))

for i in range(297):
    print("x_" + str(i) + ' = ' + str(value(x[i])))

