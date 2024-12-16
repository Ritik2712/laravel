interface BloodCompatibility {
    [key: string]: string[];
}

export const bloodCompatibilityMap: BloodCompatibility = {
    "A+": ["A+", "A-", "O+", "O-"],
    "A-": ["A-", "O-"],
    "B+": ["B+", "B-", "O+", "O-"],
    "B-": ["B-", "O-"],
    "AB+": ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
    "AB-": ["A-", "B-", "AB-", "O-"],
    "O+": ["O+", "O-"],
    "O-": ["O-"],
};

export const isBloodCompatible = (
    receiverGroup: string,
    donorGroup: string
): boolean => {
    return bloodCompatibilityMap[receiverGroup]?.includes(donorGroup) || false;
};

export const bloodGroups = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
