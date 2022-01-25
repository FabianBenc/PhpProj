import csv


class FundingRaised1:
    @staticmethod
    def where(options={}):
        with open("E:\\xampp\\htdocs\\PhpProj\\DominiksPartPython\\startup_funding.csv", "rt") as csvfile:
            data = csv.reader(csvfile, delimiter=",", quotechar='"')
            csv_data = []
            for row in data:
                csv_data.append(row)

        headers = csv_data[0]
        csv_data = FundingRaised1.check_right_column(options, csv_data, 'company_name', 1)
        csv_data = FundingRaised1.check_right_column(options, csv_data, 'city', 4)
        csv_data = FundingRaised1.check_right_column(options, csv_data, 'state', 5)
        csv_data = FundingRaised1.check_right_column(options, csv_data, 'round', 9)

        output = []
        for row in csv_data:
            mapped = dict(zip(headers, row))
            output.append(mapped)
        return output

    @staticmethod
    def check_right_column(options, csv_data, values, index):
        if values in options:
            result = []
            for row in csv_data:
                if row[index] == options[values]:
                    result.append(row)
            csv_data = result
        return csv_data

    def check_mapping(options, csv_data, values, index):
        if values in options:
            for row in csv_data:
                if row[index] == options[values]:
                    mapped = {}
                    mapped['permalink'] = row[0]
                    mapped['company_name'] = row[1]
                    mapped['number_employees'] = row[2]
                    mapped['category'] = row[3]
                    mapped['city'] = row[4]
                    mapped['state'] = row[5]
                    mapped['funded_date'] = row[6]
                    mapped['raised_amount'] = row[7]
                    mapped['raised_currency'] = row[8]
                    mapped['round'] = row[9]
                    return mapped

    @staticmethod
    def find_by(options):
        with open("E:\\xampp\\htdocs\\PhpProj\\DominiksPartPython\\startup_funding.csv", "rt") as csvfile:
            data = csv.reader(csvfile, delimiter=",", quotechar='"')
            # skip header
            next(data)
            csv_data = []
            for row in data:
                csv_data.append(row)

        temp = {'company_name' : 1, 'city': 4, 'state': 5, 'round': 9}
        for option in options:
            mappingDone = FundingRaised1.check_mapping(options, csv_data, option, temp[option])
            if mappingDone != None:
                return mappingDone

class RecordNotFound(Exception):
    pass
