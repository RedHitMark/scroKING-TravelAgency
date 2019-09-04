function timestamp2string(timestamp) {
    const d = new Date(timestamp * 1000);
    const dataFormattata =
        ('0' + d.getDate()).slice(-2) + '/' +
        ('0' + (d.getMonth() + 1)).slice(-2) + '/' +
        d.getFullYear().toString().slice(-4) + ' ' +
        ('0' + d.getHours()).slice(-2) + ':' +
        ('0' + d.getMinutes()).slice(-2);

    if (dataFormattata) {
        return dataFormattata;
    } else {
        return '';
    }
}

function string2date(stringDate) {
    const day = stringDate.slice(0, 10);
    const hour = stringDate.slice(11, 19);
    const dayParts = day.split('/');
    const hourParts = hour.split(':');

    return new Date(dayParts[2], dayParts[1] - 1, dayParts[0], hourParts[0], hourParts[1], hourParts[2]);
}

function formatStringDateTime(stringDate, daySeparator, hourSeparator) {
    const day = stringDate.slice(0, 10);
    const hour = stringDate.slice(11, 19);
    const dayParts = day.split(daySeparator);
    const hourParts = hour.split(hourSeparator);
    const mydate = new Date(dayParts[0], dayParts[1] - 1, dayParts[2], hourParts[0], hourParts[1], hourParts[2]);
    return this.timestamp2string(mydate.getTime() / 1000);
}

function formatStringDateNoTime(stringDate, daySeparator) {
    const day = stringDate.slice(0, 10);
    const dayParts = day.split(daySeparator);
    const mydate = new Date( dayParts[0], dayParts[1] - 1, dayParts[2]);
    return this.timestamp2string(mydate.getTime() / 1000);
}



function differenzaMinuti(laterdate, earlierdate) {
    const difference = laterdate.getTime() - earlierdate.getTime();
    return Math.floor(difference / 1000 / 60);
}

function differenzaGiorni(laterdate, earlierdate) {
    const difference = laterdate.getTime() - earlierdate.getTime();
    return Math.ceil(difference / 1000 / 60 / 60 / 24);
}

function differenzaOre(laterdate, earlierdate) {
    const difference = laterdate.getTime() - earlierdate.getTime();
    return Math.ceil(difference / 1000 / 60 / 60);
}