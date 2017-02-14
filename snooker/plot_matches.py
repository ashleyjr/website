import numpy as np
import matplotlib.pyplot as plt


threshold = 0

data = np.genfromtxt('matches.csv', delimiter=',', skip_header=1,skip_footer=0, names=['winner', 'w_rank', 'loser', 'l_rank'])


rank_diff = data['l_rank'] - data['w_rank']
print rank_diff

greater_wins = 0
lesser_wins = 0
unclassified = 0
for i in rank_diff:
    if i > threshold:
        greater_wins += 1
    else:
        if i < -threshold:
            lesser_wins += 1
        else:
            unclassified += 1
bet_yeild = float(greater_wins)*100/(greater_wins + lesser_wins)
greater_wins = float(greater_wins)*100/len(rank_diff)
lesser_wins = float(lesser_wins)*100/len(rank_diff)
unclassified = float(unclassified)*100/len(rank_diff)

print "Threhold " + str(threshold)
print "Greater wins " + str(greater_wins) + "%"
print "Lesser wins " + str(lesser_wins) + "%"
print "Unclassified " + str(unclassified) + "%"
print "Betting yield " + str(bet_yeild) + "%"
odds = 1 + ((100 - bet_yeild)/100)
print "Min odds " + str(odds)

plt.hist(rank_diff, bins=30)                        # plt.hist passes it's arguments to np.histogram
plt.title("Histogram with 'auto' bins")
plt.show()
