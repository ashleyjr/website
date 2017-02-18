import os


def main():
    """ Main """

    """ Get player rank """
    rank_script = "rank.py"
    rank_url = "\"http://www.snooker.org/res/index.asp?template=31&season=2016\""
    rank_file = "rank.csv"
    rank_out = "rank_run.txt"
    cmd = "python " + rank_script + " " + rank_url + " " + rank_file #+ " > " + rank_out
    print cmd
    os.system(cmd)

    print "\n\n\n\n"
    """ Get upcoming matches """
    match_script = "match.py"
    match_url = "\"http://www.snooker.org/res/index.asp?template=24&season=2016\""
    match_file = "match.csv"
    match_out = "match_run.txt"
    cmd = "python " + match_script + " " + match_url + " " + match_file #+ #" > " + match_out
    print cmd
    os.system(cmd)

if __name__ == "__main__":
    main()
