export type Activity = {
    id: string;
    log_name: string | null;
    description: string | null;
    event: string | null;
    subject_type: string | null;
    subject_label: string | null;
    subject_id: string | null;
    causer_type: string | null;
    causer_id: string | null;
    causer?: { id: string; name: string; email: string | null } | null;
    properties: Record<string, unknown> | null;
    created_at: string;
};

export type ActivitySubjectTypeOption = {
    value: string;
    label: string;
};

export type ActivityFilters = {
    user_id: string;
    subject_type: string;
    causer_type: string;
    from: string;
    to: string;
};

export type ActivityCauserTypeOption = {
    value: string;
    label: string;
};
