import numpy as np
import matplotlib.pyplot as plt

data = np.genfromtxt('matches.csv', delimiter=',', skip_header=1,skip_footer=0, names=['winner', 'w_rank', 'loser', 'l_rank'])


rank_diff = data['l_rank'] - data['w_rank']
print rank_diff

plt.hist(rank_diff, bins=30)                        # plt.hist passes it's arguments to np.histogram
plt.title("Histogram with 'auto' bins")
plt.show()
