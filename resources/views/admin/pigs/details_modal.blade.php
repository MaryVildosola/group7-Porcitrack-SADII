<div class="pig-details-hud text-left">
    @php $pendingAlert = $pig->activities->where('is_critical_alert', true)->whereNull('acknowledged_at')->first(); @endphp
    @if($pendingAlert)
    <div style="background: #fef2f2; border: 2px solid #ef4444; padding: 20px; border-radius: 20px; margin-bottom: 24px; animation: pulse-border 2s infinite;">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 48px; height: 48px; background: #fee2e2; color: #ef4444; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                <i class='bx bxs-error-alt animate-bounce'></i>
            </div>
            <div style="flex: 1;">
                <h3 style="font-size: 0.9rem; font-weight: 900; color: #991b1b; margin: 0; text-transform: uppercase;">Unresolved Critical Alert</h3>
                <p style="font-size: 0.8rem; color: #b91c1c; margin: 4px 0 12px;">Worker reported: <span style="font-weight: 700;">"{{ $pendingAlert->details }}"</span></p>
                
                <div style="background: rgba(153, 27, 27, 0.05); padding: 10px; border-radius: 12px; margin-bottom: 12px; border: 1px dashed rgba(153, 27, 27, 0.2);">
                    <p style="font-size: 0.7rem; color: #991b1b; margin: 0; font-weight: 700;">Current Physical Status: <span style="color: #64748b; font-weight: 400;">{{ $pig->health_status }} · Feeding: {{ $pig->feeding_status }}</span></p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button onclick="acknowledgeAlert({{ $pendingAlert->id }}, '{{ $pig->health_status }}', '{{ $pig->feeding_status }}', {{ json_encode($pens->map(fn($p) => ['id' => $p->id, 'name' => $p->name])) }}, {{ $pig->pen_id }})" id="ack-btn-{{ $pendingAlert->id }}" style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <i class='bx bx-check-shield'></i> Acknowledge & Update Care
                    </button>
                    <button onclick="window.quickAssignTask(event, {{ $pig->id }}, '{{ $pig->tag }}', {{ $pig->pen_id }})" style="background: #fff; color: #ef4444; border: 1px solid #ef4444; padding: 8px 16px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">
                        Add Monitor Task
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes pulse-border {
            0% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { border-color: #f87171; box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
    @endif

    <!-- Header with Background -->
    <div style="background: linear-gradient(135deg, #111827 0%, #1f2937 100%); padding: 32px; border-radius: 24px; color: white; margin-bottom: 24px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: rgba(34, 197, 94, 0.1); border-radius: 50%; blur: 40px;"></div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; position: relative; z-index: 1;">
            <div>
                <p style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #9ca3af; margin-bottom: 8px;">Individual Record</p>
                <h2 style="font-size: 2.5rem; font-weight: 900; letter-spacing: -0.05em; margin: 0;">#{{ $pig->tag }}</h2>
                <div style="display: flex; gap: 12px; margin-top: 12px;">
                    <span style="background: rgba(34, 197, 94, 0.2); color: #4ade80; padding: 4px 12px; border-radius: 99px; font-size: 0.7rem; font-weight: 700;">{{ $pig->health_status }}</span>
                    <span style="background: rgba(255, 255, 255, 0.1); color: #f3f4f6; padding: 4px 12px; border-radius: 99px; font-size: 0.7rem; font-weight: 700;">{{ $pig->breed ?? 'Standard' }}</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 12px;">
                <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.05); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                    <i class='bx bx-pig'></i>
                </div>
                <!-- Quick Assign Task Trigger -->
                <button onclick="window.quickAssignTask(event, {{ $pig->id }}, '{{ $pig->tag }}', {{ $pig->pen_id }})" data-workers="{{ json_encode($workers) }}" style="background: #22c55e; color: #fff; border: none; padding: 8px 14px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; gap: 6px; cursor: pointer; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3); transition: transform 0.2s;">
                    <i class='bx bx-task'></i> Quick Assign Task
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px;">
        <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #f1f5f9;">
            <p style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Weight</p>
            <div style="display: flex; align-items: baseline; gap: 4px;">
                <span style="font-size: 1.5rem; font-weight: 900; color: #0f172a;">{{ $pig->weight ?: '0' }}</span>
                <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;">KG</span>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #f1f5f9;">
            <p style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Age</p>
            <div style="display: flex; align-items: baseline; gap: 4px;">
                <span style="font-size: 1.5rem; font-weight: 900; color: #0f172a;">{{ round($pig->age_in_days / 7, 1) }}</span>
                <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;">WEEKS</span>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #f1f5f9;">
            <p style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">BCS</p>
            <div style="display: flex; align-items: baseline; gap: 4px;">
                <span style="font-size: 1.5rem; font-weight: 900; color: #0f172a;">{{ $pig->bcs_score ?: '3' }}</span>
                <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;">/ 5</span>
            </div>
        </div>
    </div>

    <!-- Mixture & Feeding Section -->
    <div style="margin-bottom: 32px;">
        <h3 style="font-size: 0.8rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: #475569; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-bowl-hot' style="color: #22c55e;"></i> Feeding & Mixture
        </h3>
        <div style="background: #fff; border: 1px solid #f1f5f9; border-radius: 20px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.85rem;">
                <span style="color: #64748b;">Feed Stage:</span>
                <span style="font-weight: 800; color: #1e293b;">{{ $pig->growth_stage }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.85rem;">
                <span style="color: #64748b;">Feeding Activity:</span>
                <span style="font-weight: 800; color: #1e293b;">{{ $pig->feeding_status ?: 'Normal' }}</span>
            </div>
            <div style="padding-top: 12px; border-top: 1px dashed #e2e8f0; font-size: 0.75rem; color: #64748b;">
                <p style="font-weight: 800; color: #475569; margin-bottom: 8px;">Recommended Mixture Components (approx):</p>
                @php
                    $mix = match($pig->growth_stage) {
                        'Piglet' => 'Pre-starter high protein crumbles',
                        'Starter' => '60% Corn, 25% Soya, 5% Fishmeal, 10% Rice Bran',
                        'Grower' => '65% Corn, 20% Soya, 15% Rice Bran + Minerals',
                        'Finisher' => '70% Corn, 10% Soya, 20% Rice Bran',
                        default => 'Standard Ration'
                    };
                @endphp
                <div style="background: #f1f5f9; padding: 10px; border-radius: 8px; color: #334155; font-family: monospace;">
                    {{ $mix }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs for History -->
    <div style="display: flex; gap: 8px; margin-bottom: 16px; padding: 4px; background: #f1f5f9; border-radius: 12px; width: fit-content;">
        <button class="mini-tab-btn active" onclick="switchMiniTab(event, 'th-activities')" style="padding: 6px 16px; border-radius: 8px; border: none; background: white; font-size: 0.7rem; font-weight: 800; cursor: pointer;">Activities</button>
        <button class="mini-tab-btn" onclick="switchMiniTab(event, 'th-tasks')" style="padding: 6px 16px; border-radius: 8px; border: none; background: transparent; font-size: 0.7rem; font-weight: 800; cursor: pointer; color: #64748b;">Worker Tasks</button>
    </div>

    <!-- Tab Contents -->
    <div id="th-activities" class="mini-tab-content" style="max-height: 250px; overflow-y: auto; padding-right: 8px;">
        @forelse($pig->activities as $activity)
        <div style="display: flex; gap: 12px; padding: 12px; background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; margin-bottom: 8px; align-items: flex-start;">
            <div style="width: 32px; height: 32px; border-radius: 10px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                <i class='bx {{ $activity->type === "Medical" ? "bx-plus-medical" : "bx-check" }}'></i>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <h4 style="font-size: 0.75rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $activity->action }}</h4>
                    <span style="font-size: 0.6rem; color: #94a3b8;">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
                <p style="font-size: 0.7rem; color: #64748b; margin-top: 2px;">{{ $activity->details ?: 'Recorded by worker' }}</p>
                
                @if($activity->admin_response)
                <div style="margin-top: 8px; padding: 10px; background: #f0fdf4; border-radius: 12px; border: 1px solid #dcfce7;">
                    <p style="font-size: 0.65rem; font-weight: 800; color: #166534; margin: 0; text-transform: uppercase;">Admin Response:</p>
                    <p style="font-size: 0.7rem; color: #15803d; margin: 4px 0 0;">{{ $activity->admin_response }}</p>
                    <div style="margin-top: 6px; display: flex; gap: 8px;">
                        <span style="font-size: 0.6rem; color: #166534; font-weight: 700;">Health: {{ $activity->new_health_status }}</span>
                        <span style="font-size: 0.6rem; color: #166534; font-weight: 700;">Feeding: {{ $activity->new_feeding_status }}</span>
                    </div>
                </div>
                @endif

                <div style="font-size: 0.6rem; color: #94a3b8; margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                    <i class='bx bx-user'></i> {{ $activity->user->name ?? 'System' }}
                </div>
            </div>
        </div>
        @empty
        <p style="text-align: center; font-size: 0.75rem; color: #94a3b8; padding: 20px;">No activities recorded.</p>
        @endforelse
    </div>

    <div id="th-tasks" class="mini-tab-content" style="display: none; max-height: 250px; overflow-y: auto; padding-right: 8px;">
        @forelse($pig->tasks as $task)
        <div style="padding: 12px; background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; margin-bottom: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <h4 style="font-size: 0.75rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $task->title }}</h4>
                <span style="padding: 2px 8px; border-radius: 4px; font-size: 0.6rem; background: {{ $task->status === 'completed' ? '#dcfce7' : '#fef9c3' }}; color: {{ $task->status === 'completed' ? '#166534' : '#854d0e' }};">
                    {{ ucfirst($task->status) }}
                </span>
            </div>
            <p style="font-size: 0.7rem; color: #64748b; margin-top: 4px;">{{ $task->description }}</p>
            <div style="margin-top: 8px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.6rem; color: #94a3b8;"><i class='bx bx-user'></i> {{ $task->assignee->name ?? 'Unassigned' }}</span>
                <span style="font-size: 0.6rem; color: #94a3b8;"><i class='bx bx-time'></i> {{ $task->completed_at ? $task->completed_at->format('M d') : 'Pending' }}</span>
            </div>
        </div>
        @empty
        <p style="text-align: center; font-size: 0.75rem; color: #94a3b8; padding: 20px;">No tasks linked to this pig.</p>
        @endforelse
    </div>
</div>

</div>
