import { isValid, formatDistanceToNow, parseISO } from "date-fns";

export function getReadableDate(utcDate) {
    if (!utcDate) {
        return "Invalid Date";
    }

    const parsedDate = parseISO(utcDate);
    const isValidDate = isValid(parsedDate);

    if (!isValidDate) {
        return "Invalid Date";
    }

    return formatDistanceToNow(parsedDate, "PPP h:m:");
}
