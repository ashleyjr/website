import os
import smtplib


def main():
    """ Main """

    """ Get player rank """
    rank_script = "rank.py"
    rank_url = "\"http://www.snooker.org/res/index.asp?template=31&season=2016\""
    rank_file = "rank.csv"
    rank_out = "rank_run.txt"
    cmd = "python " + rank_script + " " + rank_url + " " + rank_file + " > " + rank_out
    print cmd
    os.system(cmd)

    """ Get upcoming matches """
    match_script = "match.py"
    match_url = "\"http://www.snooker.org/res/index.asp?event=&template=24&season=2016&tzm=1\""
    match_file = "match.csv"
    match_out = "match_run.txt"
    cmd = "python " + match_script + " " + match_url + " " + match_file + " > " + match_out
    print cmd
    os.system(cmd)

    """ Only predict if there are matches today"""
    if 2 < len(open(match_file, 'r').read().split('\n')):

        """ Predict today's matches """
        predict_script = "predict.py"
        predict_rank_file = "rank.csv"
        predict_match_file = "match.csv"
        predict_file = "predict.xml"
        predict_out = "predict_out.txt"
        cmd = "python " + predict_script + " \"" + predict_rank_file + "\" \"" + predict_match_file + "\" \"" + \
            predict_file + "\"" + " > " + predict_out
        print cmd
        os.system(cmd)

        """ Tody the xml file """
        tidy_script = "tidy.py"
        tidy_xml = "predict.xml"
        tidy_out = "tidy_out.txt"
        cmd = "python " + tidy_script + " " + tidy_xml + " > " + tidy_out
        print cmd
        os.system(cmd)

        """ Get outcome of previous matches """
        outcome_script = "outcome.py"
        outcome_url = "\"http://www.snooker.org/res/index.asp?event=&template=22&season=2016&tzm=1\""
        outcome_file = "outcome.csv"
        outcome_out = "outcome_run.txt"
        cmd = "python " + outcome_script + " " + outcome_url + " " + outcome_file + " > " + outcome_out
        print cmd
        os.system(cmd)

        """ Email details """
        msg = ""
        msg += "Subject: Snooker\n"
        msg += "\n\n"
        msg += match_url
        msg += " \n\n"
        msg += open(match_out, 'r').read()
        msg += "\n\n"
        msg += open(match_file, 'r').read()
        msg += "\n\n"
        msg += rank_url
        msg += " \n\n"
        msg += open(rank_out, 'r').read()
        msg += "\n\n"
        msg += open(rank_file, 'r').read()
        email = open('email.txt', 'r').read()
        password = open('password.txt', 'r').read()
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(email, password)
        server.sendmail(email, email, msg)
        server.quit()



if __name__ == "__main__":
    main()
